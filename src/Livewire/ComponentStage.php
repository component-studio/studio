<?php

namespace Componentstudio\Studio\Livewire;

use Livewire\Component;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Component as ComponentView;

class ComponentStage extends Component
{
    public $componentFile;
    public $componentLocation;
    public $yaml_file;
    public $yaml;
    public $size;
    public $slotContent = 'asdf';
    public $code = '';

	public $studioArray;
    public $studioData;

	public $dataArray = [];
    public $dataValues = [];
	public $dataDefaultValue = [];
	public $dataDetails = [];

    public $componentProps;
    public $props;
	public $componentCode;
	public $data;

    public function mount(){
        $this->componentFile = request()->has('component') ? request()->get('component') : '';

        if(!filled($this->componentFile)){
            $this->componentFile = 'alert';
        }

		$component_path = resource_path(config('componentstudio.folder') . '/' . str_replace('.', '/', $this->componentFile) . '.blade.php');


		$contents = file_get_contents($component_path);



		preg_match('/@studio[ \t]*\(\[(.*)\]\)/sU', $contents, $matches);

		if (filled($matches)) {
            $this->studioArray = eval("return [{$matches[1]}];");
			$this->studioData = $this->studioArray['data'];
			if(isset($this->studioArray['dataDetails'])){
				$this->dataDetails = $this->studioArray['dataDetails'];
			}
        }

		$component_code_only = str_replace($matches, '', $contents);

		$component_code_only = trim($component_code_only);
		$this->componentCode = $component_code_only;

        // dd($this->componentCode);
		// dd($this->componentCode);

		$this->fillDefaultDataValues();
		$this->fillDefaultDataDetails();
		$this->loadDataValues();
		$this->generateCode();
        // dd($this->code);
    }

	private function fillDefaultDataDetails(){
        if(!isset($this->studioData)) return;
		foreach($this->studioData as $key => $value){
			if(!isset($this->dataDetails[$key]) || !isset($this->dataDetails[$key]['control'])){
				if(is_bool($value)){
					$this->dataDetails[$key]['control'] = 'boolean';
				} else {
					$this->dataDetails[$key]['control'] = 'text';
				}
			}
		}
	}

    private function addClassProp(){
        $this->yaml['props']['class'] = [
            'type' => 'text',
            'description' => 'Additional classes to be added to the button.',
            'default' => '',
        ];
    }

    public function dehydrate(){

        $this->js("alert('Post saved!')");
    }

    public function fillDefaultDataValues(){
        $this->dataValues = [];
        if(!isset($this->studioData)) return;
        foreach ($this->studioData as $key => $value) {
			$this->dataDefaultValue[$key] = $value;
            $this->dataValues[$key] = $value;
        }
    }

	public function loadDataValues(){
        if(!isset($this->studioData)) return;
        foreach ($this->studioData as $key => $value) {

			$this->dataArray[$key] = match($this->dataDetails[$key]){
				'boolean' => filter_var($this->dataValues[$key], FILTER_VALIDATE_BOOLEAN),
				default => $this->dataValues[$key]
			};

        }
		// dd($this->dataArray);
    }


    public function updated($property, $value)
    {
        $this->loadDataValues();
        $this->generateCode();
        $this->js('setTimeout(function(){ highlightCode() }, 10);');
    }

    public function generateCode(){
        $tag = 'x-'.$this->componentFile;
        $this->code = "<".$tag;
        if($this->dataArray != null){
            $componentBag = new \Illuminate\View\ComponentAttributeBag($this->dataArray);

            foreach($componentBag->getAttributes() as $attribute => $value){
                $this->code .= "\n     " . $attribute.'="'.$value.'"';
            }
        }

        $this->code .= "\n>\n\t" . $this->slotContent . "\n</".$tag.">";

    }


    public function render()
    {
        return view('componentstudio::livewire.component-stage');
    }
}

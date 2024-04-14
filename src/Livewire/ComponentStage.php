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
    public $attributeArray;
    public $attributeValues;
    public $size;
    public $slotData = '';
    public $code = '';

    public $studioData;
    public $componentProps;
    public $props;
	public $componentCode;
	public $data;

    public function mount(){
        $this->componentFile = request()->has('component') ? request()->get('component') : '';
       // $this->studioData = $this->getStudioData($this->componentFile);
        //$this->componentProps = $this->getComponentProps($this->componentFile);
        //dd($this->componentProps);

        //$this->props = $this->componentProps;

		$component_path = resource_path(config('studio.folder') . '/' . str_replace('.', '/', $this->componentFile) . '.blade.php');


		$contents = file_get_contents($component_path);

		preg_match('/@studio[ \t]*\(\[(.*)\]\)/sU', $contents, $matches);

		if (!filled($matches)) {
            return [];
        }

		$component_code_only = str_replace($matches, '', $contents);

        $component_code_only = trim($component_code_only);

		$this->componentCode = $component_code_only;


		$this->studioData = eval("return [{$matches[1]}];");



		// $rendered = Blade::render($contents);
		// dd($rendered);

		// dd($contents);

        // if the file exists

		// $component_yaml_path = resource_path(config('studio.folder') . '/' . str_replace('.', '/', $this->componentFile) . '.yml');


        // if(!file_exists($component_yaml_path)){
        //     $this->yaml = null;
        //     return;
        // }

        // $this->yaml_file = file_get_contents($component_yaml_path);
        // $this->yaml = Yaml::parse($this->yaml_file);
        // $this->componentLocation = $this->yaml['component'];
        // // dd('wtf');
        // // dd($this->componentLocation);

        // if(!isset($this->yaml['props']['class'])){
        //     $this->addClassProp();
        // }

        // $this->fillDefaultAttributeValues();
        // $this->loadAttributes();


        // $this->loadSlots($this->yaml);
        // $this->generateCode();



    }

    private function getComponentProps($componentFile){
        $componentFile = str_replace('.', '/', $componentFile);
        $fileContent = file_get_contents(resource_path(config('studio.folder') . $componentFile . '.blade.php'));
        preg_match_all('/@props\((.*?)\)/s', $fileContent, $matches);
        if($matches[1] == null) return null;
        $propsData = $matches[1][0];
        return json_decode($this->convertRawArrayStringToJSON($propsData));
    }

    private function getStudioData($componentFile){
        $componentFile = str_replace('.', '/', $componentFile);
        $fileContent = file_get_contents(resource_path(config('studio.folder') . $componentFile . '.blade.php'));
        preg_match_all('/@studio\((.*?)\)/s', $fileContent, $matches);
        if($matches[1] == null) return null;
        $studioData = $matches[1][0];
        return json_decode($this->convertRawArrayStringToJSON($studioData));
    }

    private function convertRawArrayStringToJSON($str) {
        // Trim outer whitespace and strip outer brackets if present
        $str = trim($str);
        if (substr($str, 0, 1) === '[' && substr($str, -1) === ']') {
            $str = substr($str, 1, -1);
        }

        // Replace '=>' with ':'
        $str = str_replace("=>", ":", $str);

        // Recursively handle nested arrays
        while (strpos($str, '[') !== false) {
            $str = preg_replace_callback('/\[(.*?)\]/s', function ($matches) {
                return $this->convertRawArrayStringToJSON($matches[1]);
            }, $str);
        }

        // Convert single quotes to double quotes for JSON compatibility
        $str = preg_replace("/'(.*?)'/s", "\"$1\"", $str);
        return "{" . $str . "}";
    }

    private function loadSlots($yaml){
        if(!isset($yaml['slot'])) return;
        $this->slotData = $yaml['slot']['default'];
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

    public function fillDefaultAttributeValues(){
        $this->attributeValues = [];
        if(!isset($this->yaml['props'])) return;
        foreach ($this->yaml['props'] as $prop => $details) {
            $this->attributeValues[$prop] = $details['default'];
        }
    }


    public function updated($property, $value)
    {
        $this->loadAttributes();
        $this->generateCode();
        $this->js('setTimeout(function(){ highlightCode() }, 10);');
    }

    public function generateCode(){
        $tag = 'x-'.$this->componentFile;
        $this->code = "<".$tag;
        if($this->attributeArray != null){
            $componentBag = new \Illuminate\View\ComponentAttributeBag($this->attributeArray);

            foreach($componentBag->getAttributes() as $attribute => $value){
                $this->code .= "\n     " . $attribute.'="'.$value.'"';
            }
        }
        $this->code .= "\n></".$tag.">";
    }

    public function loadAttributes(){
        if(!isset($this->yaml['props'])) return;
        foreach ($this->yaml['props'] as $prop => $details) {
            $this->attributeArray[$prop] = $this->attributeValues[$prop];
        }
    }

    public function render()
    {
        return view('studio::livewire.component-stage');
    }
}

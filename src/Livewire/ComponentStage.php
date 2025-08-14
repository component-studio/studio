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

    public function mount(){
        $this->componentFile = request()->has('component') ? request()->get('component') : '';
        //dd($this->componentFile);
        
        // Parse component source and path
        // $componentParts = explode('.', $this->componentFile);
        // if(count($componentParts) < 2){
        //     $sourceKey = 'components';
        //     $componentPath = $this->componentFile;
        // } else {
        //     $sourceKey = array_shift($componentParts);
        //     $componentPath = implode('/', $componentParts);
        // }
        
        // Get component sources from config
        $componentSources = config('componentstudio.component_sources', []);
        $componentSource = null;
        $componentLocation = '';

        //Find the component
        foreach($componentSources as $source){
            // if file exists in this source path
            if(file_exists($source['path'] . '/' . str_replace('.', '/', $this->componentFile) . '.blade.php')){
                $componentLocation = $source['path'] . '/' . str_replace('.', '/', $this->componentFile);
                $componentSource = $source;
                break;
            }
        }
        
        // Build YAML file path
        $component_yaml_path = $componentLocation . '.yml';
        
        if(!file_exists($component_yaml_path)){
            $this->yaml = null;
        } else {
            
            $this->yaml_file = file_get_contents($component_yaml_path);
            $this->yaml = Yaml::parse($this->yaml_file);
            if(!isset($this->yaml['props']['class'])){
                $this->addClassProp();
            }
        }

        $this->fillDefaultAttributeValues();
        $this->loadAttributes();


        $this->loadSlots($this->yaml);
        // if($this->code != ''){
            $this->generateCode();
        // }
        //dd($this->componentLocation);
        //dd($this->code);

    }

    private function getComponentSourceName($path) {
        $pathParts = explode('/', trim($path, '/'));
        return ucfirst(end($pathParts));
    }

    private function resolveComponentPath($path) {
        // If path is already absolute, return as-is
        if (str_starts_with($path, '/')) {
            return $path;
        }
        
        // If path starts with base_path(), app_path(), resource_path(), etc., return as-is
        if (str_contains($path, base_path()) || str_contains($path, app_path()) || str_contains($path, resource_path())) {
            return $path;
        }
        
        // Otherwise, treat as relative to project root
        return base_path($path);
    }

    private function getComponentFilePath($componentFile) {
        // Parse component source and path
        $componentParts = explode('.', $componentFile);
        if(count($componentParts) < 2){
            $sourceKey = 'components';
            $componentPath = $componentFile;
        } else {
            $sourceKey = array_shift($componentParts);
            $componentPath = implode('/', $componentParts);
        }
        
        // Get component sources from config
        $componentSources = config('componentstudio.component_sources', []);
        $componentSource = null;
        
        foreach($componentSources as $source){
            $sourceName = $source['name'] ?? $this->getComponentSourceName($source['path']);
            $sourceKeyFromName = strtolower(str_replace(' ', '_', $sourceName));
            if($sourceKeyFromName === $sourceKey){
                $componentSource = $source;
                break;
            }
        }
        
        // Fallback to legacy config if source not found
        if(!$componentSource){
            $componentSource = [
                'name' => 'Components',
                'path' => config('componentstudio.folder', 'views/components')
            ];
            $componentPath = str_replace('.', '/', $componentFile);
            return resource_path($componentSource['path'] . '/' . $componentPath . '.blade.php');
        }
        
        return $this->resolveComponentPath($componentSource['path']) . '/' . $componentPath . '.blade.php';
    }

    private function getComponentProps($componentFile){
        $componentPath = $this->getComponentFilePath($componentFile);
        if (!file_exists($componentPath)) return null;
        
        $fileContent = file_get_contents($componentPath);
        preg_match_all('/@props\((.*?)\)/s', $fileContent, $matches);
        if($matches[1] == null) return null;
        $propsData = $matches[1][0];
        return json_decode($this->convertRawArrayStringToJSON($propsData));
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
        //dd($this->componentLocation);
        $tag = 'x-'.$this->componentFile;
        $this->code = "<".$tag;
        if($this->attributeArray != null){
            $componentBag = new \Illuminate\View\ComponentAttributeBag($this->attributeArray);

            foreach($componentBag->getAttributes() as $attribute => $value){
                $this->code .= "\n     " . $attribute.'="'.$value.'"';
            }
        }
        $this->code .= "\n>";
        
        // Add slot content if it exists
        if(!empty($this->slotData)){
            $this->code .= "\n    " . $this->slotData;
        }
        
        $this->code .= "\n</".$tag.">";
    }

    public function loadAttributes(){
        if(!isset($this->yaml['props'])) return;
        foreach ($this->yaml['props'] as $prop => $details) {
            $this->attributeArray[$prop] = $this->attributeValues[$prop];
        }
    }

    public function render()
    {
        return view('componentstudio::livewire.component-stage');
    }
}

<div x-show="tab=='controls'" class="w-full relative border-t border-zinc-200">
    <div class="grid bg-zinc-100 grid-cols-4 text-sm py-2 font-medium w-full border-b justify-between px-3">
        <div>Name</div>
        <div>Description</div>
        <div>Default</div>
        <div>Controls</div>
    </div>

    @include('studio::partials.toolbox.control-row', [
        'prop' => 'slot',
        'description' => 'The main slot area of the element',
        'default' => 'Default Value',
        'type' => 'text',
        'model' => 'slotData',
        'options' => null
    ])

    @isset($this->yaml['props'])
        @foreach($this->yaml['props'] as $prop => $details)
            @include('studio::partials.toolbox.control-row', [
                'prop' => $prop,
                'description' => 'the description',
                'default' => 'default value',
                'type' => $details['type'] ?? 'text',
                'model' => 'attributeValues.' . $prop,
                'options' => ($details['options'] ?? null)
            ])
        @endforeach
    @endisset


</div>

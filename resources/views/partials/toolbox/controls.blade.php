<div x-show="tab=='controls'" class="w-full relative border-t border-zinc-200">
    <div class="grid bg-zinc-100 grid-cols-4 text-sm py-2 font-medium w-full border-b justify-between px-3">
        <div>Name</div>
        <div>Description</div>
        <div>Default</div>
        <div>Controls</div>
    </div>

    {{-- @include('componentstudio::partials.toolbox.control-row', [
        'prop' => 'slot',
        'description' => 'The main slot area of the element',
        'default' => 'Default Value',
        'type' => 'text',
        'model' => 'slotData',
        'options' => null
    ]) --}}

    @isset($dataArray)
        @foreach($dataArray as $key => $value)
            @include('componentstudio::partials.toolbox.control-row', [
				'key' => $key,
				'value' => $value,
                'description' => $dataDetails[$key]['description'] ?? '',
                'default' => $dataDefaultValue[$key] ?? '',
                'type' => $dataDetails[$key]['control'] ?? 'text',
                'model' => 'dataValues.' . $key,
                'options' => ($dataDetails[$key]['options'] ?? null)
            ])
        @endforeach
    @endisset


</div>

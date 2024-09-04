<div x-show="tab=='controls'" class="relative w-full border-t border-zinc-200">


    <div class="grid justify-between w-full grid-cols-4 px-3 py-2 text-sm font-medium border-b bg-zinc-100">
        <div>Name</div>
        <div>Description</div>
        <div>Default</div>
        <div>Controls</div>
    </div>

    <div class="grid grid-cols-4 px-4 py-3 text-sm text-zinc-500">
        <p>slot</p>
        <p>The innerHTML inside the element</p>
        <p></p>
        <div class="relative">
            <textarea wire:model.blur="slotContent"></textarea>
        </div>
    </div>
    

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

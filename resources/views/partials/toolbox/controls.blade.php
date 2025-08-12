<div x-show="tab=='controls'" class="relative w-full border-t border-zinc-200">


    <div class="grid grid-cols-4 justify-between px-3 py-2 w-full text-sm font-medium border-b bg-zinc-100">
        <div>Name</div>
        <div>Description</div>
        <div>Default</div>
        <div>Controls</div>
    </div>

    @if(isset($yaml) && $yaml)
        <!-- Slot control -->
        @if(isset($yaml['slot']))
            <div class="grid grid-cols-4 px-4 py-3 text-sm text-zinc-500">
                <p>slot</p>
                <p>The innerHTML inside the element</p>
                <p>{{ $yaml['slot']['default'] ?? '' }}</p>
                <div class="relative">
                    <textarea wire:model.blur="slotData" class="w-full rounded-lg border form-input border-zinc-300"></textarea>
                </div>
            </div>
        @endif

        <!-- YAML Props controls -->
        @if(isset($yaml['props']))
            @foreach($yaml['props'] as $key => $propDetails)
                @include('componentstudio::partials.toolbox.control-row', [
                    'key' => $key,
                    'value' => $attributeValues[$key] ?? '',
                    'description' => $propDetails['description'] ?? '',
                    'default' => $propDetails['default'] ?? '',
                    'type' => $propDetails['type'] ?? 'text',
                    'model' => 'attributeValues.' . $key,
                    'options' => ($propDetails['options'] ?? null)
                ])
            @endforeach
        @endif
    @else
        <!-- Fallback message when no YAML file is found -->
        <div class="px-4 py-8 text-center text-zinc-500">
            <p class="font-medium">No YML file found for component</p>
            <p class="mt-1 text-sm">Create a <code>{{ $componentFile }}.yml</code> file to configure component controls.</p>
        </div>
    @endif


</div>

<div class="grid grid-cols-4 px-4 text-zinc-500 py-3 text-sm">
    <label class="font-medium">{{ $key }}</label>
    <p class="text-xs pr-10">{{ $description }}</p>
    <p>{{ $default }}</p>

    <div class="relative w-full">
        @if($type == 'text')
            <input type="text" wire:model.live.debounce.250ms="{{ $model }}" class="form-input w-full rounded-lg border border-zinc-300" placeholder="{{ $value }}">
		@elseif($type == 'textarea')
			<textarea wire:model.live.debounce.250ms="{{ $model }}" class="form-input w-full rounded-lg border border-zinc-300" placeholder="{{ $value }}"></textarea>
		@elseif($type == 'boolean')

			<label class="inline-flex items-center cursor-pointer">
				<input type="checkbox" wire:model.live="{{ $model }}" class="form-input sr-only peer">
				<div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
		  	</label>

        @elseif($type == 'integer')
                <input type="number" wire:model="{{ $model }}" class="form-input rounded-lg border border-zinc-300 w-full" placeholder="{{ $value }}">
        @elseif($type == 'select')

			@php
				if(!function_exists('isAssociativeArray')){
					function isAssociativeArray(array $array) {
						// Check if all keys are integers and in sequence starting from 0
						$keys = array_keys($array);
						foreach ($keys as $key) {
							if (!is_int($key)) {
								return true; // It's associative if any key is a string
							}
						}
						return $keys !== range(0, count($array) - 1);
					}
				}
			@endphp

            <select wire:model.live="{{ $model }}" class="form-select rounded-lg border border-zinc-300 w-full">
				@php $isAssociative = isAssociativeArray($options); @endphp
                @foreach($options as $key => $value)
                    <option value="@if($isAssociative){{ $key }}@else{{ $value }}@endif">{{ $value }}</option>
                @endforeach
            </select>
        @endif
    </div>
</div>

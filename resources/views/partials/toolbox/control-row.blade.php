<div class="grid grid-cols-4 px-4 text-zinc-500 py-3 text-sm">
    <label class="font-medium">{{ $prop }}</label>
    <p class="text-xs">{{ $description }}</p>
    <p>{{ $default }}</p>

    <div class="relative w-full">
        @if($type == 'text')
            <input type="text" wire:model.live.debounce.250ms="{{ $model }}" class="form-input w-full rounded-lg border border-zinc-300" placeholder="{{ $prop }}">

        @elseif($type == 'number')
                <input type="number" wire:model="{{ $model }}" class="form-input rounded-lg border border-zinc-300 w-full" placeholder="{{ $prop }}">
        @elseif($type == 'select')

            <select wire:model.live="{{ $model }}" class="form-select rounded-lg border border-zinc-300 w-full">
                <option value="">Select {{ $prop }}</option>
                @foreach($details['options'] as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        @endif
    </div>
</div>

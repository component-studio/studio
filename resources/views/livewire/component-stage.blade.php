<div class="h-full w-full flex flex-col split" wire:ignore.self x-cloak>
    @if(!empty($componentCode))
        <div id="stage" wire:key="stage" class="w-full h-auto flex-1 flex items-center justify-center flex-col relative" wire:ignore.self>

                {!! \Blade::render($componentCode, $dataArray) !!}

            <div wire:loading.delay class="w-auto absolute bottom-0 right-0 text-white mb-2 mr-2 text-xs font-semibold bg-black/50 rounded flex items-center justify-center">
                <div class="flex items-center justify-center h-8 px-2">
                    <svg class="animate-spin mr-1.5 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span>Loading</span>
                </div>
            </div>
        </div><div id="gutter" wire:key="gutter" class="gutter gutter-vertical" style="height: 10px;" wire:ignore></div><div id="toolbox" wire:key="toolbox" class="relative w-full" wire:ignore.self>
            @include('componentstudio::partials.component-toolbox')
        </div>
    @else
        <div class="flex flex-col items-center h-full justify-center">
            <p class="font-semibold mb-2">No component found for {{ $componentFile }}</p>
            <p class="text-sm text-zinc-500">Make sure the component exists at {{ 'resources/' . (config('componentstudio.folder')) . '/' . $componentFile . '.blade.php' }}, and is not empty.</p>
        </div>
    @endif
</div>

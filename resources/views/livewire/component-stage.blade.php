<div class="flex flex-col w-full h-full split" wire:ignore.self x-cloak>
    @if(!$componentFile)
        <div class="flex flex-col justify-center items-center w-full h-full">
            <div class="text-3xl font-bold">Welcome to Component Studio</div>
            <p class="text-zinc-500">Select a component from the left</p>
        </div>
    @else
        @if(!empty($code))
            <div id="stage" wire:key="stage" class="flex relative flex-col flex-1 justify-center items-center w-full h-auto" wire:ignore.self>
                {!! \Blade::render($code) !!}
                <div wire:loading.delay class="flex absolute right-0 bottom-0 justify-center items-center mr-2 mb-2 w-auto text-xs font-semibold text-white rounded bg-black/50">
                    <div class="flex justify-center items-center px-2 h-8">
                        <svg class="mr-1.5 w-4 h-4 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>Loading</span>
                    </div>
                </div>
            </div>
            <div id="gutter" wire:key="gutter" class="gutter gutter-vertical" style="height: 10px;" wire:ignore></div><div id="toolbox" wire:key="toolbox" class="relative w-full" wire:ignore.self>
                @include('componentstudio::partials.component-toolbox')
            </div>
        @else
            <div class="flex flex-col justify-center items-center h-full">
                <p class="mb-2 font-semibold">No component found for {{ $componentFile }}</p>
                <p class="text-sm text-zinc-500">Make sure the component exists at {{ 'resources/' . (config('componentstudio.folder')) . '/' . $componentFile . '.blade.php' }}, and is not empty.</p>
            </div>
        @endif
    @endif
</div>

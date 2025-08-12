<div x-data="{ tab : 'controls' }" class="flex overflow-hidden relative flex-col w-full h-full bg-white border-t border-zinc-200">
    <ul class="flex relative top-0 left-0 z-50 flex-shrink-0 items-stretch w-full h-10 text-sm font-bold bg-white border-b text-zinc-400 border-zinc-200">
        <li><button data-name="controls" @click="tab=$el.dataset.name" :class="{ 'border-blue-500 text-zinc-700' : tab == $el.dataset.name, 'border-transparent' : tab != $el.dataset.name }" class="px-4 h-full border-b-2">Controls</button></li>
        {{-- <li><button data-name="accessibility" @click="tab=$el.dataset.name" :class="{ 'border-blue-500 text-zinc-700' : tab == $el.dataset.name, 'border-transparent' : tab != $el.dataset.name }" class="px-4 h-full border-b-2">Accessibility</button></li> --}}
        <li><button data-name="code" @click="tab=$el.dataset.name" :class="{ 'border-blue-500 text-zinc-700' : tab == $el.dataset.name, 'border-transparent' : tab != $el.dataset.name }" class="px-4 h-full border-b-2">Code</button></li>
    </ul>
    <div class="overflow-scroll relative h-full">
    @include('componentstudio::partials.toolbox.controls')
    @include('componentstudio::partials.toolbox.code')
    </div>
</div>

<div x-data="{ tab : 'controls' }" class="w-full bg-white border-t flex-col flex overflow-hidden h-full border-zinc-200 relative">
    <ul class="w-full flex items-stretch text-sm font-bold text-zinc-400 relative h-10 flex-shrink-0 top-0 border-b border-zinc-200 left-0 z-50 bg-white">
        <li><button data-name="controls" @click="tab=$el.dataset.name" :class="{ 'border-blue-500 text-zinc-700' : tab == $el.dataset.name, 'border-transparent' : tab != $el.dataset.name }" class="px-4 h-full border-b-2">Controls</button></li>
        <li><button data-name="accessibility" @click="tab=$el.dataset.name" :class="{ 'border-blue-500 text-zinc-700' : tab == $el.dataset.name, 'border-transparent' : tab != $el.dataset.name }" class="px-4 h-full border-b-2">Accessibility</button></li>
        <li><button data-name="code" @click="tab=$el.dataset.name" :class="{ 'border-blue-500 text-zinc-700' : tab == $el.dataset.name, 'border-transparent' : tab != $el.dataset.name }" class="px-4 h-full border-b-2">Code</button></li>
    </ul>
    <div class="relative h-full overflow-scroll">
    @include('studio::partials.toolbox.controls')
    @include('studio::partials.toolbox.code')
    </div>
</div>

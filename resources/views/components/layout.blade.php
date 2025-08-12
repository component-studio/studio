<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=epilogue:300,500,700&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Scripts -->
        @vite(['packages/componentstudio/studio/resources/css/app.css', 'packages/componentstudio/studio/resources/js/app.js'])
    </head>
    <body class="flex items-stretch h-full font-sans antialiased bg-zinc-50">
        <div class="fixed w-64 h-screen bg-zinc-50">
            <div class="flex items-center p-5 space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 100 96" fill="none"><path fill="currentColor" d="M99.921 22.892c-.016-.053-.038-.101-.058-.152a2.09 2.09 0 0 0-.158-.326 1.888 1.888 0 0 0-.349-.412c-.041-.037-.078-.075-.121-.108-.02-.015-.035-.036-.057-.05-.13-.09-.27-.163-.418-.217l-26.044-9.97V10c0-.406-.045-.8-.133-1.183-.175-.764-.519-1.481-1.008-2.151a7.986 7.986 0 0 0-.84-.968 10.166 10.166 0 0 0-.725-.646c-.099-.081-.207-.155-.31-.232-.166-.126-.329-.251-.505-.371-.142-.097-.291-.189-.439-.282-.15-.096-.3-.19-.453-.28-.18-.105-.364-.206-.549-.303-.136-.072-.271-.145-.41-.215a22.151 22.151 0 0 0-1.784-.798l-.291-.113c-.292-.11-.586-.219-.888-.323-.068-.023-.137-.044-.205-.068-.335-.111-.672-.22-1.021-.324C61.019 1.107 58.66.641 56.217.352a51.171 51.171 0 0 0-2.979-.263h-.004c-1-.06-2-.089-3.001-.089h-.003c-9.536 0-19.599 2.684-21.965 7.706A5.324 5.324 0 0 0 27.747 10v1.175L1.242 21.164a1.893 1.893 0 0 0-.417.215c-.02.013-.033.031-.053.046-.046.034-.084.075-.126.113-.089.08-.17.164-.243.257-.108.143-.196.3-.261.468-.021.055-.044.106-.062.163a1.94 1.94 0 0 0-.078.499l-.002.02v52.263c0 .789.487 1.497 1.224 1.779l48.325 18.497c.017.007.035.004.052.01.204.072.414.116.629.116.213 0 .421-.043.622-.112.017-.006.033-.003.051-.01l47.864-18.035A1.905 1.905 0 0 0 100 75.67V23.412c0-.179-.032-.352-.079-.52ZM31.642 9.516a2.26 2.26 0 0 1 .219-.449c.032-.053.077-.105.115-.158.069-.1.142-.2.229-.301.057-.065.126-.131.19-.197.087-.088.176-.176.276-.264a9.45 9.45 0 0 1 1.259-.9c.146-.089.299-.179.461-.267.099-.054.203-.106.306-.161.19-.098.382-.195.59-.292.072-.034.149-.067.225-.1 2.062-.929 4.876-1.728 8.298-2.19l.034-.005c.491-.065.992-.125 1.508-.174l.06-.007a44.516 44.516 0 0 1 1.586-.128h.005a49.896 49.896 0 0 1 6.624.004c1.817.122 3.493.341 5.026.627l.318.061c1.213.236 2.329.518 3.343.829l.307.096c.491.158.964.321 1.402.491l.019.008c.424.166.815.339 1.188.514l.271.13c.362.179.707.36 1.015.543l.027.019c.344.208.675.437.99.687.234.188.45.375.627.562.489.521.745 1.035.745 1.507 0 2.522-7.273 6.187-18.672 6.187-.843 0-1.654-.026-2.45-.064-.239-.01-.47-.027-.704-.042a49.524 49.524 0 0 1-1.673-.133c-.225-.022-.449-.043-.67-.068a41.958 41.958 0 0 1-1.859-.251c-.08-.013-.165-.022-.244-.036a36.654 36.654 0 0 1-2.02-.39c-.094-.02-.182-.043-.273-.064-.633-.145-1.26-.31-1.883-.493-2.702-.8-4.688-1.815-5.814-2.826-.044-.04-.086-.078-.125-.117a4.528 4.528 0 0 1-.286-.287 3.636 3.636 0 0 1-.301-.378c-.038-.055-.064-.11-.096-.164a2.39 2.39 0 0 1-.202-.447 1.547 1.547 0 0 1-.074-.425c0-.166.029-.33.083-.487Zm37.263 6.213v6.526c0 2.521-7.271 6.185-18.669 6.185v-8.442c7.049 0 14.366-1.474 18.669-4.269Zm-41.158-.48v7.006c0 6.494 11.584 9.999 22.483 9.999 10.902 0 22.487-3.505 22.487-9.999v-6.519l20.009 7.66-23.27 8.77-19.22 7.244-17.323-6.632-25.639-9.814 20.473-7.715Zm68.442 59.102L52.136 90.95V42.767l15.686-5.911 28.367-10.689v48.184Z"/></svg>
                <p class="font-semibold">component<span class="font-light">studio</span></p>
            </div>

            <?php

                if(!function_exists('scanDirectory')){
                    function scanDirectory($dir) {
                        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::SELF_FIRST);
                        $components = [];

                        foreach ($iterator as $file) {
                            if ($file->isDir()) {
                                $relativePath = substr($file->getPathname(), strlen($dir));
                                if (in_array($relativePath, ['/.', '/..'])) continue;
                                $components[ltrim($relativePath, '/')] = [];
                            } else if ($file->getExtension() == 'php') {
                                $relativePath = substr($file->getPathname(), strlen($dir));
                                $relativeDir = dirname($relativePath);
                                if (in_array($relativeDir, ['/.', '/..'])) continue;
                                $components[ltrim($relativeDir, '/')][] = str_replace('.blade.php', '', basename($relativePath));
                            }
                        }

                        // Sort directories before files
                        uksort($components, function($a, $b) {
                            if ($a == '/' || $a == '.') return 1;
                            if ($b == '/' || $b == '.') return -1;
                            return count(explode(DIRECTORY_SEPARATOR, $a)) - count(explode(DIRECTORY_SEPARATOR, $b));
                        });

                        return $components;
                    }
                }

                $dir = resource_path(config('componentstudio.folder'));
                $components = scanDirectory($dir);
                $activeComponent = request()->has('component') ? request()->get('component') : '';
                $activeFolder = explode('.', $activeComponent)[0];

				if(!empty($components)){
					$componentOrganizedInFolder = [];
					$componentOrganizedRoot = [];
					foreach($components as $folder => $file){
						if(!Str::endsWith($folder, ['/.', '/..'])){
							if($folder == ''){
								$componentOrganizedRoot[$folder] = $file;
							} else {
								$componentOrganizedInFolder[$folder] = $file;
							}
						}
					}

					$components = [...$componentOrganizedInFolder, ...$componentOrganizedRoot];
				}
            ?>
            {{-- @dd($components); --}}



            <div class="select-none">
                @foreach($components as $folder => $files)
                    @php
                        $subfolder = false;
                        if($folder != ''){ $subfolder = true; }
                        $isActiveFolder = $activeFolder == $folder ? 'true' : 'false';
                    @endphp

                    @if($subfolder)
                        <div x-data="{ open: {{ $isActiveFolder }} }" class="mb-5 border-t border-b border-zinc-200">
                            <h2 @click="open=!open" :class="{ 'bg-blue-600 text-white font-bold' : open }" class="flex items-center px-5 py-2 text-sm cursor-pointer folder-name">
                                <svg class="mr-1.5 w-3 h-3" x-show="!open" x-cloak xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 256 256"><path d="M216,72H131.31L104,44.69A15.86,15.86,0,0,0,92.69,40H40A16,16,0,0,0,24,56V200.62A15.4,15.4,0,0,0,39.38,216H216.89A15.13,15.13,0,0,0,232,200.89V88A16,16,0,0,0,216,72ZM40,56H92.69l16,16H40ZM216,200H40V88H216Z"></path></svg>
								<svg lass="w-3 h-3 mr-1.5" x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 256 256"><path d="M245,110.64A16,16,0,0,0,232,104H216V88a16,16,0,0,0-16-16H130.67L102.94,51.2a16.14,16.14,0,0,0-9.6-3.2H40A16,16,0,0,0,24,64V208h0a8,8,0,0,0,8,8H211.1a8,8,0,0,0,7.59-5.47l28.49-85.47A16.05,16.05,0,0,0,245,110.64ZM93.34,64,123.2,86.4A8,8,0,0,0,128,88h72v16H69.77a16,16,0,0,0-15.18,10.94L40,158.7V64Zm112,136H43.1l26.67-80H232Z"></path></svg>


                                {{-- <svg :class="{ 'rotate-90' : open }" class="w-4 h-4 duration-300 ease-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M6.22 4.22a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06L8.94 8 6.22 5.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" /></svg> --}}
                                <span>{{ $folder }}</span>
                            </h1>
                    @endif

                        <div @if($subfolder) x-show="open" x-collapse x-cloak @endif>
                            @foreach($files as $file)
                                <a href="{{ config('componentstudio.url' ) }}?component={{ trim($folder . '.' . $file, '.') }}" wire:navigate class="@if($activeComponent == trim($folder . '.' . $file, '.')){{ 'bg-blue-500 text-white font-semibold' }}@else{{ 'font-normal text-gray-600 hover:text-gray-800 hover:bg-zinc-200/70' }}@endif @if($subfolder){{ 'pl-8' }}@else{{ 'pl-5' }}@endif pr-5 flex items-center py-1.5 text-sm ">
                                    <svg class="mr-1.5 w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 256 256"><path d="M184,32H72A16,16,0,0,0,56,48V224a8,8,0,0,0,12.24,6.78L128,193.43l59.77,37.35A8,8,0,0,0,200,224V48A16,16,0,0,0,184,32Zm0,177.57-51.77-32.35a8,8,0,0,0-8.48,0L72,209.57V48H184Z"></path></svg>
                                    <span>{{ $file }}</span>
                                </a>
                            @endforeach
                        </div>

                    @if($subfolder)
                        </div>
                    @endif
                @endforeach
            </div>

        </div>

        <div class="flex items-stretch pt-2 ml-64 w-full h-screen justify-stretch shadow-top-left">
            <div class="flex justify-center items-center w-full h-full bg-white rounded-tl-xl border-t border-l border-zinc-200/60">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

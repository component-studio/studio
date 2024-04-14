<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>The Chronicles of Laravel</title>
    
    @if(config('chronicles.dev'))
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="http://localhost:5173/resources/js/app.js" type="module"></script>
    @else
    {{-- {{ Vite::useBuildDirectory('chronicles')->withEntryPoints(['resources/js/app.js']) }} --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'], 'chronicles/build')
    @endif
    @livewireStyles
</head>
<body>

    <div id="start" class="flex items-center justify-center w-screen h-screen bg-black bg-cover" style="background-image:url('/chronicles/images/assets/background-zoom-out.png')">
        <div class="fixed inset-0 z-10 w-screen h-screen bg-black opacity-50"></div>
        <button onclick="start()" class="relative z-20 px-3 py-2 text-black bg-white rounded-md">Begin My Journey</button>
    </div>
    <div id="chronicle" class="flex items-center justify-center hidden w-screen h-screen bg-cover" style="background-image:url('/chronicles/images/background.png')">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
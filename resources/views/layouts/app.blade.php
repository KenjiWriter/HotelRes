<!DOCTYPE html>
<html lang="pl" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" x-bind:class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@yield('styles')
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <header class="bg-white dark:bg-gray-800 shadow-md py-4 mb-8">
        <div class="container mx-auto flex justify-between items-center px-4">
            <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" class="text-sm bg-gray-300 dark:bg-gray-700 text-black dark:text-white px-3 py-1 rounded">
                <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
            </button>
            <a href="{{ route('home') }}" class="text-xl font-bold text-center mx-auto">Hotel Reservation App</a>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
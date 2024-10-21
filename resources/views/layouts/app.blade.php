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
            <form action="{{ route('locale.change') }}" method="POST" >
                @csrf
                <select class="dark:text-gray-300 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md p-2 outline-none transition duration-300 ease-in-out" name="locale" onchange="this.form.submit()">
                    <option value="en"{{ app()->getLocale() == 'en' ? ' selected' : '' }}>English</option>
                    <option value="pl"{{ app()->getLocale() == 'pl' ? ' selected' : '' }}>Polski</option>
                </select>
            </form>
        </div>
    </header>
    @if(session('success'))
        <div class="container mx-auto px-4 py-2 mb-4 bg-green-100 border border-green-400 text-green-700 rounded relative" role="alert">
            <strong class="font-bold">Sukces!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="container mx-auto px-4 py-2 mb-4 bg-red-100 border border-red-400 text-red-700 rounded relative" role="alert">
            <strong class="font-bold">Błąd!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="container mx-auto px-4 py-8">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
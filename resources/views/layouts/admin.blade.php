<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }" x-bind:class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Panel Admina</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex">
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-gray-800 dark:bg-gray-700 min-h-screen">
            <div class="flex items-center justify-center h-16 bg-gray-900 dark:bg-gray-800">
                <span class="text-white text-lg font-bold">Panel Admina</span>
            </div>
            <nav class="mt-5">
                <!-- Dark Mode Toggle -->
                <div class="px-6 py-3">
                    <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')"
                            class="w-full flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 rounded">
                        <svg x-show="!darkMode" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"/>
                        </svg>
                        <span x-text="darkMode ? 'Tryb jasny' : 'Tryb ciemny'"></span>
                    </button>
                </div>

                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-6 py-3 text-gray-100 hover:bg-gray-700 dark:hover:bg-gray-800 
                          {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 dark:bg-gray-800' : '' }}">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.rooms.index') }}"
                class="flex items-center px-6 py-3 text-gray-100 hover:bg-gray-700 dark:hover:bg-gray-800
                        {{ request()->routeIs('admin.rooms.*') ? 'bg-gray-700 dark:bg-gray-800' : '' }}">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Pokoje
                </a>

                <a href="#" 
                   class="flex items-center px-6 py-3 text-gray-100 hover:bg-gray-700 dark:hover:bg-gray-800">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Rezerwacje
                </a>

                <a href="#" 
                   class="flex items-center px-6 py-3 text-gray-100 hover:bg-gray-700 dark:hover:bg-gray-800">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Użytkownicy
                </a>

                <div class="px-6 py-4">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center px-4 py-2 text-gray-100 hover:bg-gray-700 dark:hover:bg-gray-800 rounded">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Wyloguj
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Navigation -->
            <nav class="bg-white dark:bg-gray-800 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <h1 class="text-xl font-semibold text-gray-800 dark:text-white">
                                {{ config('app.name', 'Laravel') }}
                            </h1>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="py-6">
                @yield('content')
            </main>
        </div>
    </div>

    @livewireScripts
    @yield('scripts')
</body>
</html>

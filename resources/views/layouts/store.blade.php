<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Topup Store') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-900 text-gray-200 min-h-screen">
        <!-- Header -->
        <header class="bg-gray-800 border-b border-gray-700 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Left: Burger & Logo & Branding -->
                    <div class="flex items-center space-x-4">
                        <!-- Burger Icon -->
                        <button class="text-gray-400 hover:text-white focus:outline-none focus:text-white transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        
                        <!-- Logo & Title -->
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('images/logo_transparent.png') }}" alt="Logo" class="h-10 w-10 rounded-full object-cover">
                            <div class="hidden sm:block">
                                <h1 class="text-xl font-bold font-sans text-white uppercase tracking-wider leading-tight">Tokoku</h1>
                                <p class="text-xs text-gray-400">Topup Game Murah & Cepat</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Search -->
                    <div class="flex items-center space-x-4">
                        <button class="text-gray-400 hover:text-white focus:outline-none transition duration-150 relative group">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>

                        <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-400 hover:text-white transition duration-150">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto w-full">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 border-t border-gray-700 mt-12 py-6 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} Tokoku. All rights reserved.
        </footer>
    </body>
</html>

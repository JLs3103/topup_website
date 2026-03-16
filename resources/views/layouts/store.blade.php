<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Topup Store') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('app', {
                    sidebarOpen: false,
                    searchOpen: false,
                    searchQuery: '',
                });
            });
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-900 text-gray-200 min-h-screen" x-data>

        <div
            x-show="$store.app.sidebarOpen"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="$store.app.sidebarOpen = false"
            class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40"
            style="display:none;"
        ></div>

        <aside
            x-show="$store.app.sidebarOpen"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-gray-800 border-r border-gray-700 shadow-2xl flex flex-col overflow-y-auto"
            style="display:none;"
        >
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-700 shrink-0">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-9 rounded-full object-cover">
                    <span class="font-bold text-white uppercase tracking-wide text-sm">Tokoku</span>
                </div>
                <button @click="$store.app.sidebarOpen = false" class="text-gray-400 hover:text-white transition p-1 rounded-lg hover:bg-gray-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            @auth
            <div class="px-5 py-4 border-b border-gray-700 bg-gray-900/50 shrink-0">
                <div class="flex items-center space-x-3">
                    <div class="h-9 w-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-semibold text-gray-100 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
            @endauth

            <nav class="flex-1 px-3 py-4 space-y-0.5">

                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-200 hover:bg-indigo-500/20 hover:text-indigo-300 transition group">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="text-sm font-medium">Beranda</span>
                </a>

                <p class="px-3 pt-4 pb-1 text-xs font-semibold text-gray-500 uppercase tracking-widest">Kategori Game</p>

                @php
                    $sidebarGames = collect(config('topup_games.games', []))->values();
                @endphp

                @foreach($sidebarGames as $sg)
                <a href="{{ route('games.show', $sg['slug']) }}" class="flex items-center space-x-3 px-3 py-2 rounded-lg text-gray-300 hover:bg-indigo-500/20 hover:text-indigo-300 transition group">
                    <img src="{{ asset($sg['image']) }}" class="h-6 w-6 rounded object-cover shrink-0" alt="{{ $sg['name'] }}">
                    <span class="text-sm">{{ $sg['name'] }}</span>
                </a>
                @endforeach

                <div class="border-t border-gray-700 my-3"></div>

                <a href="{{ route('orders.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-200 hover:bg-indigo-500/20 hover:text-indigo-300 transition group">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="text-sm font-medium">Riwayat Transaksi</span>
                </a>

                <a href="{{ route('account.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-200 hover:bg-indigo-500/20 hover:text-indigo-300 transition group">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span class="text-sm font-medium">Profil Saya</span>
                </a>

                <a href="{{ route('faq.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-200 hover:bg-indigo-500/20 hover:text-indigo-300 transition group">
                    <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium">Bantuan & FAQ</span>
                </a>

                @if (auth()->user()?->hasRole('admin'))
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-200 hover:bg-indigo-500/20 hover:text-indigo-300 transition group">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-sm font-medium">Verifikasi Pembayaran</span>
                    </a>

                    <a href="{{ route('admin.faqs.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-200 hover:bg-indigo-500/20 hover:text-indigo-300 transition group">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m0 0v10m0-10a2 2 0 100 4m0-4a2 2 0 110 4"/>
                        </svg>
                        <span class="text-sm font-medium">Admin FAQ</span>
                    </a>

                    <a href="{{ route('admin.activity-logs.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-gray-200 hover:bg-indigo-500/20 hover:text-indigo-300 transition group">
                        <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-sm font-medium">Log Aktivitas Admin</span>
                    </a>
                @endif

                <div class="border-t border-gray-700 my-3"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-red-400 hover:bg-red-500/10 hover:text-red-300 transition group">
                        <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="text-sm font-medium">Log Out</span>
                    </button>
                </form>

            </nav>
        </aside>

        <header class="bg-gray-800 border-b border-gray-700 sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center h-16 gap-4">

                    <div class="flex items-center space-x-4 shrink-0">
                        <button
                            @click="$store.app.sidebarOpen = !$store.app.sidebarOpen"
                            class="text-gray-400 hover:text-white focus:outline-none transition duration-150 ease-in-out p-1 rounded-lg hover:bg-gray-700"
                            aria-label="Toggle menu"
                        >
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 rounded-full object-cover">
                            <div class="hidden sm:block">
                                <h1 class="text-xl font-bold font-sans text-white uppercase tracking-wider leading-tight">Tokoku</h1>
                                <p class="text-xs text-gray-400">Topup Game Murah & Cepat</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 flex justify-end items-center gap-3">

                        <div
                            x-show="$store.app.searchOpen"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="flex-1 flex items-center bg-gray-700/70 border border-gray-600 rounded-xl px-3 py-1.5 gap-2"
                            style="display:none;"
                            @click.stop
                        >
                            <svg class="h-4 w-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input
                                x-ref="searchInput"
                                x-model="$store.app.searchQuery"
                                @keydown.escape="$store.app.searchOpen = false; $store.app.searchQuery = ''"
                                type="text"
                                placeholder="Cari game..."
                                class="flex-1 bg-transparent text-sm text-gray-100 placeholder:text-gray-400 focus:outline-none"
                            >
                            <button
                                x-show="$store.app.searchQuery.length > 0"
                                @click="$store.app.searchQuery = ''"
                                class="text-gray-400 hover:text-white transition"
                                style="display:none;"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <button
                            @click="
                                $store.app.searchOpen = !$store.app.searchOpen;
                                if ($store.app.searchOpen) { $nextTick(() => $refs.searchInput.focus()) }
                                else { $store.app.searchQuery = '' }
                            "
                            class="text-gray-400 hover:text-white focus:outline-none transition duration-150 p-1 rounded-lg hover:bg-gray-700 shrink-0"
                            aria-label="Search"
                        >
                            <svg x-show="!$store.app.searchOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <svg x-show="$store.app.searchOpen" class="h-6 w-6" style="display:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                        <form method="POST" action="{{ route('logout') }}" class="hidden sm:block shrink-0">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-400 hover:text-white transition duration-150">
                                Log Out
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto w-full">
            {{ $slot }}
        </main>

        <footer class="bg-gray-800 border-t border-gray-700 mt-12 py-6 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} Tokoku. All rights reserved.
        </footer>
    </body>
</html>

<x-store-layout>
    <div class="w-full bg-indigo-600 overflow-hidden py-2 relative shadow-md">
        <div class="whitespace-nowrap animate-marquee flex items-center space-x-12 text-white font-semibold text-sm tracking-wide">
            <span>🔥 PROMO TOPUP MLBB DISKON 20% HARI INI!</span>
            <span>💎 DIAMOND FREE FIRE TERMURAH SE-INDONESIA!</span>
            <span>⚡ FLASH SALE VALORANT POINT JAM 12:00 - 15:00!</span>
            <span>🔥 PROMO TOPUP MLBB DISKON 20% HARI INI!</span>
            <span>💎 DIAMOND FREE FIRE TERMURAH SE-INDONESIA!</span>
            <span>⚡ FLASH SALE VALORANT POINT JAM 12:00 - 15:00!</span>
            <span>🔥 PROMO TOPUP MLBB DISKON 20% HARI INI!</span>
        </div>
    </div>

    <div class="w-full px-4 sm:px-6 lg:px-8 mt-6">
        <div class="w-full h-48 md:h-72 bg-gradient-to-tr from-purple-800 via-indigo-700 to-blue-600 rounded-3xl shadow-xl flex items-center justify-center relative overflow-hidden group">
            <div class="absolute inset-0 bg-black opacity-20 group-hover:opacity-10 transition duration-500"></div>
            <div class="absolute top-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full mix-blend-overlay filter blur-xl transform -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-pink-500 opacity-20 rounded-full mix-blend-overlay filter blur-3xl transform translate-x-1/3 translate-y-1/3"></div>
            
            <div class="relative z-10 text-center px-4">
                <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-3 drop-shadow-lg tracking-tight">TOPUP CEPAT, AMAN & MUDAH</h2>
                <p class="text-lg text-indigo-100 font-medium drop-shadow-md">Buka 24 Jam Non-Stop. Otomatis Masuk Detik Itu Juga!</p>
            </div>
        </div>
    </div>

    <div class="w-full px-4 sm:px-6 lg:px-8 mt-12 mb-16">
        <div class="flex items-center space-x-3 mb-8 border-b border-gray-700 pb-4">
            <div class="p-2 bg-indigo-500/20 rounded-lg">
                <svg class="w-6 h-6 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-white tracking-wide">Paling Populer</h2>
        </div>

        @php
            $games = collect(config('topup_games.games', []))
                ->values()
                ->map(function (array $game): array {
                    return [
                        'slug' => $game['slug'],
                        'name' => $game['name'],
                        'dev' => $game['developer'],
                        'img' => asset($game['image']),
                    ];
                });
        @endphp

        <div x-data>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5 md:gap-8">
                @foreach($games as $game)
                    <a
                        href="{{ route('games.show', $game['slug']) }}"
                        class="group block outline-none"
                        x-show="'{{ strtolower($game['name']) }}'.includes($store.app.searchQuery.toLowerCase().trim())"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                    >
                        <div class="bg-gray-800 rounded-2xl p-4 shadow-lg hover:shadow-indigo-500/20 transition-all duration-300 border border-gray-700 hover:border-indigo-500 transform hover:-translate-y-2 h-full flex flex-col">
                            <div class="w-full relative pt-[100%] rounded-xl overflow-hidden mb-4 shadow-inner">
                                <img src="{{ $game['img'] }}" alt="{{ $game['name'] }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-in-out">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-0 group-hover:opacity-60 transition duration-300"></div>
                            </div>

                            <div class="text-left mt-auto">
                                <h3 class="text-base sm:text-lg font-bold text-gray-100 group-hover:text-indigo-400 transition-colors duration-200 leading-tight mb-1">{{ $game['name'] }}</h3>
                                <p class="text-xs text-gray-400 font-medium">{{ $game['dev'] }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div
                x-show="{{ $games->map(fn($g) => "'".strtolower($g['name'])."'.includes(\$store.app.searchQuery.toLowerCase().trim())")->join(' || ') }} ? false : true"
                class="col-span-full flex flex-col items-center py-16 text-gray-500"
                style="display:none;"
            >
                <svg class="h-12 w-12 mb-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <p class="text-base font-medium">Game tidak ditemukan</p>
                <p class="text-sm mt-1">Coba kata kunci lain</p>
            </div>

        </div>
    </div>
</x-store-layout>

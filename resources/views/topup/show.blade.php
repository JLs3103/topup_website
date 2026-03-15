<x-store-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="{{ asset($game['image']) }}" alt="{{ $game['name'] }}" class="w-20 h-20 rounded-xl object-cover">
                        <div>
                            <h1 class="text-2xl font-bold text-white">Topup {{ $game['name'] }}</h1>
                            <p class="text-sm text-gray-400">{{ $game['developer'] }} • Proses otomatis 1-5 menit</p>
                        </div>
                    </div>

                    <form action="{{ route('games.order.store', $game['slug']) }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <h2 class="text-lg font-semibold text-white mb-3">1. Masukkan Data Akun</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-gray-300 mb-1">{{ $game['player_id_label'] }}</label>
                                    <input type="text" name="player_id" value="{{ old('player_id') }}" class="w-full rounded-lg bg-gray-900 border border-gray-700 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masukkan {{ strtolower($game['player_id_label']) }}" required>
                                    @error('player_id')
                                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                @if ($game['requires_server'])
                                    <div>
                                        <label class="block text-sm text-gray-300 mb-1">{{ $game['server_id_label'] }}</label>
                                        <input type="text" name="server_id" value="{{ old('server_id') }}" class="w-full rounded-lg bg-gray-900 border border-gray-700 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masukkan {{ strtolower($game['server_id_label']) }}" required>
                                        @error('server_id')
                                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-white mb-3">2. Pilih Nominal</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach ($game['packages'] as $packageId => $package)
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="package_id" value="{{ $packageId }}" class="hidden peer" {{ old('package_id') === $packageId ? 'checked' : '' }}>
                                        <div class="rounded-xl border border-gray-700 bg-gray-900 p-4 peer-checked:border-indigo-500 peer-checked:bg-indigo-500/10 group-hover:border-indigo-400 transition">
                                            <p class="font-semibold text-white">{{ $package['name'] }}</p>
                                            <p class="text-sm text-indigo-300 mt-1">Rp {{ number_format($package['price'], 0, ',', '.') }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('package_id')
                                <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-white mb-3">3. Metode Pembayaran</h2>
                            <select name="payment_method" class="w-full rounded-lg bg-gray-900 border border-gray-700 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Pilih metode pembayaran</option>
                                @foreach ($paymentMethods as $key => $label)
                                    <option value="{{ $key }}" {{ old('payment_method') === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('payment_method')
                                <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <h2 class="text-lg font-semibold text-white mb-3">4. Kontak</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <select name="contact_type" class="w-full rounded-lg bg-gray-900 border border-gray-700 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Pilih kontak</option>
                                        <option value="whatsapp" {{ old('contact_type') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                        <option value="email" {{ old('contact_type') === 'email' ? 'selected' : '' }}>Email</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <input type="text" name="contact_value" value="{{ old('contact_value') }}" class="w-full rounded-lg bg-gray-900 border border-gray-700 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" placeholder="08xxxx / email@domain.com" required>
                                </div>
                            </div>
                            @error('contact_type')
                                <p class="text-red-400 text-xs mt-2">{{ $message }}</p>
                            @enderror
                            @error('contact_value')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-500 hover:to-blue-500 font-semibold text-white">
                            Buat Pesanan Topup
                        </button>
                    </form>
                </div>
            </div>

            <div>
                <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 sticky top-24">
                    <h3 class="text-lg font-semibold text-white mb-4">Cara Topup</h3>
                    <ol class="space-y-3 text-sm text-gray-300">
                        <li>1. Isi ID akun game dengan benar.</li>
                        <li>2. Pilih nominal diamond/UC/VP sesuai kebutuhan.</li>
                        <li>3. Pilih metode pembayaran yang tersedia.</li>
                        <li>4. Selesaikan pembayaran sebelum batas waktu.</li>
                        <li>5. Item masuk otomatis ke akun Anda.</li>
                    </ol>

                    <div class="mt-6 border-t border-gray-700 pt-4">
                        <p class="text-xs text-gray-400">Butuh bantuan? Hubungi CS kami 24 jam melalui WhatsApp.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-store-layout>

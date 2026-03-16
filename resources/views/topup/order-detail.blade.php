<x-store-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Detail Transaksi</h1>
                        <p class="text-sm text-gray-400 mt-1">Kode: <span class="font-semibold text-indigo-300">{{ $order->order_code }}</span></p>
                    </div>
                    <a href="{{ route('orders.index') }}" class="text-sm text-indigo-300 hover:text-indigo-200">Kembali ke riwayat</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="rounded-xl border border-gray-700 bg-gray-900 px-4 py-3">
                        <p class="text-gray-400">Game</p>
                        <p class="text-gray-100 font-medium">{{ $order->game_name }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-700 bg-gray-900 px-4 py-3">
                        <p class="text-gray-400">Status</p>
                        <p class="text-gray-100 font-medium uppercase">{{ $order->status }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-700 bg-gray-900 px-4 py-3">
                        <p class="text-gray-400">Akun Game</p>
                        <p class="text-gray-100 font-medium">{{ $order->player_id }}{{ $order->server_id ? ' ('.$order->server_id.')' : '' }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-700 bg-gray-900 px-4 py-3">
                        <p class="text-gray-400">Metode Pembayaran</p>
                        <p class="text-gray-100 font-medium">{{ $order->metadata['payment_label'] ?? strtoupper($order->payment_method) }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-700 bg-gray-900 px-4 py-3">
                        <p class="text-gray-400">Paket</p>
                        <p class="text-gray-100 font-medium">{{ $order->package_name }}</p>
                    </div>
                    <div class="rounded-xl border border-gray-700 bg-gray-900 px-4 py-3">
                        <p class="text-gray-400">Total Bayar</p>
                        <p class="text-indigo-300 font-semibold">Rp {{ number_format($order->package_price, 0, ',', '.') }}</p>
                    </div>
                </div>

                @if ($order->payment_proof_path)
                    <div class="mt-6 rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-4">
                        <p class="text-sm text-emerald-300 font-semibold mb-2">Bukti pembayaran sudah diupload</p>
                        <a href="{{ asset('storage/'.$order->payment_proof_path) }}" target="_blank" class="text-sm text-emerald-200 underline">Lihat bukti pembayaran</a>
                        @if ($order->paid_at)
                            <p class="text-xs text-emerald-200 mt-2">Dikirim pada {{ $order->paid_at->format('d M Y H:i') }}</p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="space-y-4">
                @if ($order->status === 'pending')
                    <div class="bg-gray-800 border border-gray-700 rounded-2xl p-5 shadow-xl">
                        <h2 class="text-lg font-semibold text-white mb-2">Bayar Sekarang</h2>
                        <p class="text-sm text-gray-400 mb-4">Simulasi pembayaran: lakukan transfer sesuai nominal, lalu upload bukti pembayaran.</p>

                        <form method="POST" action="{{ route('orders.pay', $order) }}" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <div>
                                <label class="block text-sm text-gray-300 mb-1">Upload Bukti Pembayaran</label>
                                <input type="file" name="payment_proof" accept="image/*,.pdf" class="w-full text-sm text-gray-300 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-600 file:px-3 file:py-2 file:text-white hover:file:bg-indigo-500" required>
                                @error('payment_proof')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm text-gray-300 mb-1">Catatan (opsional)</label>
                                <textarea name="payment_notes" rows="3" class="w-full rounded-lg bg-gray-900 border border-gray-700 text-gray-100 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: transfer via m-banking">{{ old('payment_notes') }}</textarea>
                                @error('payment_notes')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2.5">
                                Kirim Bukti Pembayaran
                            </button>
                        </form>
                    </div>
                @endif

                <div class="bg-gray-800 border border-gray-700 rounded-2xl p-5 shadow-xl">
                    <h2 class="text-sm font-semibold text-gray-300 uppercase tracking-wide mb-3">Bantuan</h2>
                    <p class="text-sm text-gray-400">Jika ada kendala, hubungi CS dengan menyebutkan kode transaksi {{ $order->order_code }}.</p>
                    <a href="{{ route('faq.index') }}" class="inline-block mt-3 text-sm text-indigo-300 hover:text-indigo-200">Lihat FAQ</a>
                </div>
            </div>
        </div>
    </div>
</x-store-layout>

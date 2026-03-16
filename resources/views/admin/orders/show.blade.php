<x-store-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-white">Detail Verifikasi</h1>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-indigo-300 hover:text-indigo-200">Kembali</a>
                </div>

                @if (session('status'))
                    <div class="mb-4 rounded-lg bg-emerald-500/15 border border-emerald-500/40 text-emerald-300 px-4 py-3 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="rounded-xl bg-gray-900 border border-gray-700 px-4 py-3">
                        <p class="text-gray-400">Kode</p>
                        <p class="text-gray-100 font-semibold">{{ $order->order_code }}</p>
                    </div>
                    <div class="rounded-xl bg-gray-900 border border-gray-700 px-4 py-3">
                        <p class="text-gray-400">Status</p>
                        <p class="text-gray-100 font-semibold uppercase">{{ $order->status }}</p>
                    </div>
                    <div class="rounded-xl bg-gray-900 border border-gray-700 px-4 py-3">
                        <p class="text-gray-400">User ID</p>
                        <p class="text-gray-100 font-semibold">{{ $order->user_id }}</p>
                    </div>
                    <div class="rounded-xl bg-gray-900 border border-gray-700 px-4 py-3">
                        <p class="text-gray-400">Game</p>
                        <p class="text-gray-100 font-semibold">{{ $order->game_name }}</p>
                    </div>
                    <div class="rounded-xl bg-gray-900 border border-gray-700 px-4 py-3">
                        <p class="text-gray-400">Akun Game</p>
                        <p class="text-gray-100 font-semibold">{{ $order->player_id }}{{ $order->server_id ? ' ('.$order->server_id.')' : '' }}</p>
                    </div>
                    <div class="rounded-xl bg-gray-900 border border-gray-700 px-4 py-3">
                        <p class="text-gray-400">Total</p>
                        <p class="text-indigo-300 font-semibold">Rp {{ number_format($order->package_price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="mt-6 rounded-xl bg-gray-900 border border-gray-700 px-4 py-4">
                    <p class="text-sm text-gray-300 mb-2">Bukti Pembayaran</p>
                    @if ($order->payment_proof_path)
                        <a href="{{ asset('storage/'.$order->payment_proof_path) }}" target="_blank" class="text-indigo-300 hover:text-indigo-200 underline">Lihat berkas bukti</a>
                    @else
                        <p class="text-sm text-gray-500">Belum ada bukti pembayaran diupload.</p>
                    @endif
                </div>

                @if (! empty($order->payment_notes))
                    <div class="mt-4 rounded-xl bg-gray-900 border border-gray-700 px-4 py-4">
                        <p class="text-sm text-gray-300 mb-2">Catatan User</p>
                        <p class="text-sm text-gray-400">{{ $order->payment_notes }}</p>
                    </div>
                @endif
            </div>

            <div class="bg-gray-800 border border-gray-700 rounded-2xl p-5 shadow-xl h-fit">
                <h2 class="text-lg font-semibold text-white mb-3">Aksi Verifikasi</h2>
                <p class="text-sm text-gray-400 mb-4">Ubah status transaksi dan kirim notifikasi otomatis ke user.</p>

                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="space-y-3">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm text-gray-300 mb-1">Status Baru</label>
                        <select name="status" class="w-full rounded-lg bg-gray-900 border border-gray-700 text-gray-100 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Pilih status</option>
                            <option value="success" {{ old('status') === 'success' ? 'selected' : '' }}>Success</option>
                            <option value="failed" {{ old('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                        @error('status')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-300 mb-1">Catatan Admin (opsional)</label>
                        <textarea name="admin_note" rows="4" class="w-full rounded-lg bg-gray-900 border border-gray-700 text-gray-100 text-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('admin_note') }}</textarea>
                        @error('admin_note')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2.5">Simpan Verifikasi</button>
                </form>
            </div>
        </div>
    </div>
</x-store-layout>

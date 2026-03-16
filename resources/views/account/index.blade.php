<x-store-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl">
                <h1 class="text-2xl font-bold text-white mb-6">Profil Saya</h1>

                @if (session('status'))
                    <div class="mb-4 rounded-lg bg-emerald-500/15 border border-emerald-500/40 text-emerald-300 px-4 py-3 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="space-y-4">
                    <div class="rounded-xl bg-gray-900 border border-gray-700 px-4 py-3">
                        <p class="text-xs text-gray-400">Nama</p>
                        <p class="text-sm text-gray-100 font-medium">{{ $user->name }}</p>
                    </div>

                    <div class="rounded-xl bg-gray-900 border border-gray-700 px-4 py-3">
                        <p class="text-xs text-gray-400">Email</p>
                        <p class="text-sm text-gray-100 font-medium">{{ $user->email }}</p>
                    </div>

                    <div class="rounded-xl bg-gray-900 border border-gray-700 px-4 py-3">
                        <p class="text-xs text-gray-400">Bergabung Sejak</p>
                        <p class="text-sm text-gray-100 font-medium">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('profile') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-sm font-semibold text-white transition">
                        Edit Profil & Password
                    </a>
                    <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-sm font-semibold text-gray-100 transition">
                        Lihat Riwayat Transaksi
                    </a>
                </div>

                <div class="mt-8 border-t border-gray-700 pt-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-white">Notifikasi</h2>
                        @if ($unreadCount > 0)
                            <form method="POST" action="{{ route('notifications.read-all') }}">
                                @csrf
                                <button type="submit" class="text-xs text-indigo-300 hover:text-indigo-200">Tandai semua dibaca ({{ $unreadCount }})</button>
                            </form>
                        @endif
                    </div>

                    <div class="space-y-3">
                        @forelse ($recentNotifications as $notification)
                            <div class="rounded-xl border {{ $notification->read_at ? 'border-gray-700 bg-gray-900/60' : 'border-indigo-500/40 bg-indigo-500/10' }} px-4 py-3">
                                <p class="text-sm font-medium text-gray-100">{{ $notification->data['title'] ?? 'Notifikasi' }}</p>
                                <p class="text-sm text-gray-300 mt-1">{{ $notification->data['message'] ?? '-' }}</p>
                                @if (! empty($notification->data['order_id']))
                                    <a href="{{ route('orders.show', $notification->data['order_id']) }}" class="inline-block mt-2 text-xs text-indigo-300 hover:text-indigo-200">Lihat transaksi</a>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">Belum ada notifikasi.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="bg-gray-800 border border-gray-700 rounded-2xl p-5 shadow-xl">
                    <h2 class="text-sm font-semibold text-gray-300 uppercase tracking-wide mb-4">Ringkasan Akun</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">Total Transaksi</span>
                            <span class="text-white font-semibold">{{ $stats['total_orders'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">Pending</span>
                            <span class="text-amber-300 font-semibold">{{ $stats['pending_orders'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400">Sukses</span>
                            <span class="text-emerald-300 font-semibold">{{ $stats['completed_orders'] }}</span>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-700 pt-3 mt-2">
                            <span class="text-gray-400">Total Belanja</span>
                            <span class="text-indigo-300 font-semibold">Rp {{ number_format($stats['total_spend'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 border border-gray-700 rounded-2xl p-5 shadow-xl">
                    <h2 class="text-sm font-semibold text-gray-300 uppercase tracking-wide mb-3">Pusat Bantuan</h2>
                    <p class="text-sm text-gray-400 mb-4">Butuh bantuan mengenai transaksi atau akun Anda?</p>
                    <a href="{{ route('faq.index') }}" class="text-sm font-semibold text-indigo-300 hover:text-indigo-200">Buka Bantuan & FAQ</a>
                </div>
            </div>
        </div>
    </div>
</x-store-layout>

<x-store-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-white">Riwayat Topup</h1>
                <a href="{{ route('dashboard') }}" class="text-sm text-indigo-300 hover:text-indigo-200">Kembali ke dashboard</a>
            </div>

            <form method="GET" action="{{ route('orders.index') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-3">
                <div class="md:col-span-2">
                    <input
                        type="text"
                        name="q"
                        value="{{ $keyword }}"
                        placeholder="Cari kode transaksi atau nama game"
                        class="w-full rounded-lg bg-gray-900 border border-gray-700 text-gray-100 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </div>
                <div>
                    <select name="status" class="w-full rounded-lg bg-gray-900 border border-gray-700 text-gray-100 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ $selectedStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $selectedStatus === 'paid' ? 'selected' : '' }}>Paid (Menunggu Verifikasi)</option>
                        <option value="success" {{ $selectedStatus === 'success' ? 'selected' : '' }}>Success</option>
                        <option value="failed" {{ $selectedStatus === 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="canceled" {{ $selectedStatus === 'canceled' ? 'selected' : '' }}>Canceled</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold px-4 py-2.5">
                        Filter
                    </button>
                    <a href="{{ route('orders.index') }}" class="rounded-lg bg-gray-700 hover:bg-gray-600 text-gray-100 text-sm font-semibold px-4 py-2.5">
                        Reset
                    </a>
                </div>
            </form>

            <div class="mb-6 grid grid-cols-2 md:grid-cols-4 gap-3">
                <div class="rounded-xl border border-gray-700 bg-gray-900 px-4 py-3">
                    <p class="text-xs text-gray-400">Total</p>
                    <p class="text-lg font-semibold text-white">{{ $statusCounts->sum() }}</p>
                </div>
                <div class="rounded-xl border border-gray-700 bg-gray-900 px-4 py-3">
                    <p class="text-xs text-gray-400">Pending</p>
                    <p class="text-lg font-semibold text-amber-300">{{ $statusCounts['pending'] ?? 0 }}</p>
                </div>
                <div class="rounded-xl border border-gray-700 bg-gray-900 px-4 py-3">
                    <p class="text-xs text-gray-400">Success</p>
                    <p class="text-lg font-semibold text-emerald-300">{{ $statusCounts['success'] ?? 0 }}</p>
                </div>
                <div class="rounded-xl border border-gray-700 bg-gray-900 px-4 py-3">
                    <p class="text-xs text-gray-400">Failed/Canceled</p>
                    <p class="text-lg font-semibold text-rose-300">{{ ($statusCounts['failed'] ?? 0) + ($statusCounts['canceled'] ?? 0) }}</p>
                </div>
            </div>

            @if (session('status'))
                <div class="mb-4 rounded-lg bg-emerald-500/15 border border-emerald-500/40 text-emerald-300 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($orders->isEmpty())
                <div class="text-center py-12 text-gray-400">
                    <p>Belum ada transaksi topup.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="text-gray-400 border-b border-gray-700">
                            <tr>
                                <th class="py-3 pr-4">Kode</th>
                                <th class="py-3 pr-4">Game</th>
                                <th class="py-3 pr-4">Nominal</th>
                                <th class="py-3 pr-4">Pembayaran</th>
                                <th class="py-3 pr-4">Status</th>
                                <th class="py-3 pr-4">Waktu</th>
                                <th class="py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($orders as $order)
                                <tr class="text-gray-200">
                                    <td class="py-3 pr-4 font-medium">
                                        <a href="{{ route('orders.show', $order) }}" class="text-indigo-300 hover:text-indigo-200 underline">{{ $order->order_code }}</a>
                                    </td>
                                    <td class="py-3 pr-4">{{ $order->game_name }}</td>
                                    <td class="py-3 pr-4">
                                        <div>{{ $order->package_name }}</div>
                                        <div class="text-indigo-300">Rp {{ number_format($order->package_price, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="py-3 pr-4">{{ $order->metadata['payment_label'] ?? strtoupper($order->payment_method) }}</td>
                                    <td class="py-3 pr-4">
                                        <span class="px-2 py-1 rounded-md text-xs font-semibold {{
                                            $order->status === 'pending'
                                                ? 'bg-amber-500/15 text-amber-300 border border-amber-500/40'
                                                : ($order->status === 'success'
                                                    ? 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/40'
                                                    : ($order->status === 'paid'
                                                        ? 'bg-sky-500/15 text-sky-300 border border-sky-500/40'
                                                        : 'bg-rose-500/15 text-rose-300 border border-rose-500/40'))
                                        }}">
                                            {{ strtoupper($order->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 pr-4">{{ $order->created_at->format('d M Y H:i') }}</td>
                                    <td class="py-3">
                                        @if ($order->status === 'pending')
                                            <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center px-3 py-1.5 rounded-md bg-indigo-600 hover:bg-indigo-500 text-xs font-semibold text-white">
                                                Bayar Sekarang
                                            </a>
                                        @else
                                            <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center px-3 py-1.5 rounded-md bg-gray-700 hover:bg-gray-600 text-xs font-semibold text-gray-100">
                                                Detail
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-store-layout>

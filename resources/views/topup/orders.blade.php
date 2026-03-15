<x-store-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-white">Riwayat Topup</h1>
                <a href="{{ route('dashboard') }}" class="text-sm text-indigo-300 hover:text-indigo-200">Kembali ke dashboard</a>
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
                                <th class="py-3">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($orders as $order)
                                <tr class="text-gray-200">
                                    <td class="py-3 pr-4 font-medium">{{ $order->order_code }}</td>
                                    <td class="py-3 pr-4">{{ $order->game_name }}</td>
                                    <td class="py-3 pr-4">
                                        <div>{{ $order->package_name }}</div>
                                        <div class="text-indigo-300">Rp {{ number_format($order->package_price, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="py-3 pr-4">{{ $order->metadata['payment_label'] ?? strtoupper($order->payment_method) }}</td>
                                    <td class="py-3 pr-4">
                                        <span class="px-2 py-1 rounded-md text-xs font-semibold {{ $order->status === 'pending' ? 'bg-amber-500/15 text-amber-300 border border-amber-500/40' : 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/40' }}">
                                            {{ strtoupper($order->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3">{{ $order->created_at->format('d M Y H:i') }}</td>
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

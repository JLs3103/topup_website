<x-store-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-white">Verifikasi Pembayaran</h1>
                <a href="{{ route('admin.activity-logs.index') }}" class="text-sm text-indigo-300 hover:text-indigo-200">Lihat Log Aktivitas</a>
            </div>

            <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-3">
                <div class="md:col-span-2">
                    <input type="text" name="q" value="{{ $keyword }}" placeholder="Cari kode/game/player id" class="w-full rounded-lg bg-gray-900 border border-gray-700 text-gray-100 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <select name="status" class="w-full rounded-lg bg-gray-900 border border-gray-700 text-gray-100 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="paid" {{ $selectedStatus === 'paid' ? 'selected' : '' }}>Paid (Default)</option>
                        <option value="pending" {{ $selectedStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="success" {{ $selectedStatus === 'success' ? 'selected' : '' }}>Success</option>
                        <option value="failed" {{ $selectedStatus === 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold px-4 py-2.5">Filter</button>
                    <a href="{{ route('admin.orders.index') }}" class="rounded-lg bg-gray-700 hover:bg-gray-600 text-gray-100 text-sm font-semibold px-4 py-2.5">Reset</a>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="text-gray-400 border-b border-gray-700">
                        <tr>
                            <th class="py-3 pr-4">Kode</th>
                            <th class="py-3 pr-4">User</th>
                            <th class="py-3 pr-4">Game</th>
                            <th class="py-3 pr-4">Nominal</th>
                            <th class="py-3 pr-4">Status</th>
                            <th class="py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse ($orders as $order)
                            <tr class="text-gray-200">
                                <td class="py-3 pr-4">{{ $order->order_code }}</td>
                                <td class="py-3 pr-4">#{{ $order->user_id }}</td>
                                <td class="py-3 pr-4">{{ $order->game_name }}</td>
                                <td class="py-3 pr-4">Rp {{ number_format($order->package_price, 0, ',', '.') }}</td>
                                <td class="py-3 pr-4 uppercase">{{ $order->status }}</td>
                                <td class="py-3">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-300 hover:text-indigo-200 underline">Detail & Verifikasi</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">Tidak ada data transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $orders->links() }}</div>
        </div>
    </div>
</x-store-layout>

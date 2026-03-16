<x-store-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-white">Log Aktivitas Admin</h1>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-indigo-300 hover:text-indigo-200">Kembali ke Verifikasi</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="text-gray-400 border-b border-gray-700">
                        <tr>
                            <th class="py-3 pr-4">Waktu</th>
                            <th class="py-3 pr-4">Admin</th>
                            <th class="py-3 pr-4">Aksi</th>
                            <th class="py-3">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse ($logs as $log)
                            <tr class="text-gray-200 align-top">
                                <td class="py-3 pr-4 whitespace-nowrap">{{ $log->created_at->format('d M Y H:i') }}</td>
                                <td class="py-3 pr-4">{{ $log->admin->name ?? 'Admin' }}</td>
                                <td class="py-3 pr-4"><span class="uppercase text-xs text-indigo-300">{{ str_replace('_', ' ', $log->action) }}</span></td>
                                <td class="py-3">
                                    <p>{{ $log->description }}</p>
                                    @if (! empty($log->meta))
                                        <pre class="mt-2 text-xs text-gray-400 whitespace-pre-wrap">{{ json_encode($log->meta, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-400">Belum ada log aktivitas admin.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $logs->links() }}</div>
        </div>
    </div>
</x-store-layout>

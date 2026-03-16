<x-store-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-white">Admin FAQ</h1>
                <a href="{{ route('admin.faqs.create') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-sm font-semibold text-white">Tambah FAQ</a>
            </div>

            @if (session('status'))
                <div class="mb-4 rounded-lg bg-emerald-500/15 border border-emerald-500/40 text-emerald-300 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-gray-400 border-b border-gray-700">
                        <tr>
                            <th class="text-left py-3 pr-4">Urutan</th>
                            <th class="text-left py-3 pr-4">Pertanyaan</th>
                            <th class="text-left py-3 pr-4">Status</th>
                            <th class="text-left py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse ($faqs as $faq)
                            <tr class="text-gray-200">
                                <td class="py-3 pr-4">{{ $faq->sort_order }}</td>
                                <td class="py-3 pr-4">{{ $faq->question }}</td>
                                <td class="py-3 pr-4">
                                    <span class="px-2 py-1 rounded-md text-xs font-semibold {{ $faq->is_active ? 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/40' : 'bg-gray-500/15 text-gray-300 border border-gray-500/40' }}">
                                        {{ $faq->is_active ? 'AKTIF' : 'NONAKTIF' }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="text-indigo-300 hover:text-indigo-200">Edit</a>
                                        <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('Hapus FAQ ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-300 hover:text-rose-200">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-400">Belum ada data FAQ.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $faqs->links() }}
            </div>
        </div>
    </div>
</x-store-layout>

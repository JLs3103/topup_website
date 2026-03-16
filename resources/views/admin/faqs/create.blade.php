<x-store-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-3xl mx-auto bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl">
            <h1 class="text-2xl font-bold text-white mb-6">Tambah FAQ</h1>

            <form method="POST" action="{{ route('admin.faqs.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm text-gray-300 mb-1">Pertanyaan</label>
                    <input type="text" name="question" value="{{ old('question') }}" class="w-full rounded-lg bg-gray-900 border border-gray-700 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('question')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm text-gray-300 mb-1">Jawaban</label>
                    <textarea name="answer" rows="5" class="w-full rounded-lg bg-gray-900 border border-gray-700 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('answer') }}</textarea>
                    @error('answer')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-300 mb-1">Urutan</label>
                        <input type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full rounded-lg bg-gray-900 border border-gray-700 text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <label class="inline-flex items-center mt-7">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-600 bg-gray-900 text-indigo-500 focus:ring-indigo-500" {{ old('is_active', true) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-300">Aktifkan FAQ</span>
                    </label>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-sm font-semibold text-white">Simpan</button>
                    <a href="{{ route('admin.faqs.index') }}" class="px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-sm font-semibold text-gray-100">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-store-layout>

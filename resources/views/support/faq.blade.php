<x-store-layout>
    <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-4xl mx-auto bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl">
            <h1 class="text-2xl font-bold text-white mb-2">Bantuan & FAQ</h1>
            <p class="text-sm text-gray-400 mb-6">Pertanyaan yang paling sering ditanyakan pengguna topup.</p>

            @php
                $defaultFaqs = [
                    ['question' => 'Berapa lama proses topup?', 'answer' => 'Umumnya 1-5 menit setelah pembayaran berhasil. Pada kondisi tertentu dapat memakan waktu lebih lama.'],
                    ['question' => 'Kenapa topup saya belum masuk?', 'answer' => 'Pastikan ID akun benar dan pembayaran sudah sukses. Jika sudah lebih dari 15 menit, hubungi CS dengan kode transaksi Anda.'],
                    ['question' => 'Apakah bisa refund jika salah ID?', 'answer' => 'Transaksi yang sudah diproses umumnya tidak bisa refund. Selalu cek ulang ID akun sebelum melakukan pembayaran.'],
                    ['question' => 'Metode pembayaran apa saja yang tersedia?', 'answer' => 'Kami mendukung QRIS, Virtual Account, serta e-wallet populer sesuai pilihan pada halaman checkout.'],
                    ['question' => 'Bagaimana menghubungi customer service?', 'answer' => 'Silakan hubungi WhatsApp CS yang tertera di website dan sertakan kode transaksi agar penanganan lebih cepat.'],
                ];
            @endphp

            <div class="space-y-4">
                @forelse ($faqs as $faq)
                    <details class="group rounded-xl border border-gray-700 bg-gray-900 px-4 py-3" {{ $loop->first ? 'open' : '' }}>
                        <summary class="cursor-pointer font-semibold text-gray-100">{{ $faq->question }}</summary>
                        <p class="mt-2 text-sm text-gray-400">{{ $faq->answer }}</p>
                    </details>
                @empty
                    @foreach ($defaultFaqs as $item)
                        <details class="group rounded-xl border border-gray-700 bg-gray-900 px-4 py-3" {{ $loop->first ? 'open' : '' }}>
                            <summary class="cursor-pointer font-semibold text-gray-100">{{ $item['question'] }}</summary>
                            <p class="mt-2 text-sm text-gray-400">{{ $item['answer'] }}</p>
                        </details>
                    @endforeach
                @endforelse
            </div>

            <div class="mt-8 border-t border-gray-700 pt-5 flex flex-wrap gap-3">
                <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-sm font-semibold text-white transition">Lihat Riwayat Transaksi</a>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-700 hover:bg-gray-600 text-sm font-semibold text-gray-100 transition">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</x-store-layout>

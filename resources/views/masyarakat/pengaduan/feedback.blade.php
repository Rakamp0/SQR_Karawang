<x-app-layout>
    {{-- Header halaman --}}
    <x-slot name="header">
        <h2 class="font-black text-2xl text-green-800 leading-tight">
            {{ __('Beri Masukan & Dapat Poin') }} 🌟
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            {{-- Card putih utama --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-green-100 p-8">

                {{-- Bagian judul dan icon --}}
                <div class="text-center mb-8">
                    {{-- Icon jempol --}}
                    <div
                        class="bg-green-100 text-green-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                        👍
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Bagaimana Pengalamanmu?</h3>
                    {{-- Menampilkan judul laporan yang sedang diisi feedback --}}
                    <p class="text-gray-500 text-sm">Laporan: <strong>{{ $aduan->Judul_Pengaduan }}</strong></p>
                </div>

                {{-- Form feedback --}}
                {{-- Mengirim data ke controller feedback fungsi store --}}
                {{-- Parameter ID Pengaduan disisipkan di URL --}}
                <form action="{{ route('masyarakat.feedback.store', $aduan->Id_Pengaduan) }}" method="POST">
                    @csrf
                    {{-- Pertanyaan: Efektivitas --}}
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Seberapa Puas dengan Hasilnya?</label>
                        <select name="efektivitas"
                            class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
                            <option value="Sangat Puas">🤩 Sangat Puas</option>
                            <option value="Puas">🙂 Puas</option>
                            <option value="Biasa Saja">😐 Biasa Saja</option>
                            <option value="Tidak Puas">🙁 Tidak Puas</option>
                            <option value="Sangat Tidak Puas">😡 Sangat Tidak Puas</option>
                        </select>
                    </div>

                    {{-- Pertanyaan: Kemudahan --}}
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Apakah Prosesnya Mudah?</label>
                        <select name="kemudahan"
                            class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
                            <option value="Sangat Mudah">⚡ Sangat Mudah</option>
                            <option value="Mudah">✅ Mudah</option>
                            <option value="Biasa Saja">🤔 Biasa Saja</option>
                            <option value="Sulit">😓 Sulit</option>
                            <option value="Sangat Sulit">🤯 Sangat Sulit</option>
                        </select>
                    </div>

                    {{-- 3. Pertanyaan: Kualitas layanan --}}
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Bagaimana dengan Pelayanan
                            Petugas?</label>
                        <select name="reward"
                            class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500">
                            <option value="Sangat Senang">🥰 Sangat Senang</option>
                            <option value="Senang">😊 Senang</option>
                            <option value="Biasa Saja">😐 Biasa Saja</option>
                            <option value="Tidak Senang">😒 Tidak Senang</option>
                            <option value="Sangat Tidak Senang">😤 Sangat Tidak Senang</option>
                        </select>
                    </div>

                    {{-- Komentar --}}
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Ceritakan Pengalamanmu</label>
                        <textarea name="komentar" rows="3"
                            class="w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring-green-500"
                            placeholder="Contoh: Petugasnya gercep banget, makasih SQR!"></textarea>
                    </div>

                    {{-- Tombol kirim --}}
                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl shadow-lg transition-all transform hover:-translate-y-1">
                        Kirim Feedback (+1 Poin) 🚀
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
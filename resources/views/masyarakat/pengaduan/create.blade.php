<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            {{-- Tombol back --}}
            <a href="{{ route('masyarakat.pengaduan.index') }}"
                class="mr-4 text-gray-400 hover:text-green-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-black text-2xl text-green-800 leading-tight">
                {{ __('Buat Pengaduan Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifikasi error (aler) --}}
            {{-- Alert Gagal --}}
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-100 text-red-700 p-4 rounded-2xl shadow-sm flex items-center"
                    role="alert">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <p class="font-bold">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Alert Validasi Input --}}
            {{-- Muncul jika user lupa ngisi field atau format salah --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-100 text-red-700 p-4 rounded-2xl shadow-sm">
                    <p class="font-bold mb-2">Periksa kembali inputan Anda:</p>
                    <ul class="list-disc ml-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Card form aduan --}}
            <div class="bg-white p-8 md:p-10 shadow-sm rounded-3xl border border-gray-100">

                {{-- enctype="multipart/form-data" untuk mengirim foto ke server --}}
                <form action="{{ route('masyarakat.pengaduan.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf {{-- Token keamanan wajib --}}

                    {{-- Input judul --}}
                    <div>
                        <label class="block font-black text-green-800 uppercase tracking-wider text-xs mb-2">Judul
                            Aduan</label>
                        <input type="text" name="judul" value="{{ old('judul') }}"
                            class="w-full border-gray-200 rounded-xl shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition duration-200"
                            placeholder="Masukan judul aduan..." maxlength="30" required>
                    </div>

                    {{-- Input kategori --}}
                    <div class="mt-4">
                        <label for="kategori" class="block font-medium text-sm text-gray-700">Kategori Aduan</label>
                        <select name="kategori" id="kategori"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full mt-1"
                            required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            <option value="Infrastruktur">Infrastruktur (Jalan, Jembatan, dll)</option>
                            <option value="Lingkungan">Lingkungan (Sampah, Banjir, dll)</option>
                            <option value="Fasilitas">Fasilitas Umum (Taman, Halte, dll)</option>
                            <option value="Keamanan">Keamanan (Pencurian, Tawuran, dll)</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    {{-- Input deskripsi --}}
                    <div>
                        <label class="block font-black text-green-800 uppercase tracking-wider text-xs mb-2">Deskripsi
                            Laporan</label>
                        <textarea name="deskripsi" rows="5"
                            class="w-full border-gray-200 rounded-xl shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition duration-200"
                            placeholder="Ceritakan detail kejadian secara lengkap..." maxlength="255"
                            required>{{ old('deskripsi') }}</textarea>
                    </div>

                    {{-- Upload foto --}}
                    <div class="p-6 bg-green-50 rounded-2xl border border-green-100">
                        <label class="block font-black text-green-700 uppercase tracking-wider text-xs mb-2">Upload
                            Dokumentasi (Foto)</label>

                        <input type="file" name="foto"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-green-600 file:text-white hover:file:bg-green-700 transition-all cursor-pointer"
                            required>

                        <div class="mt-3 flex items-center text-xs text-green-600 font-medium">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            Format: JPG, JPEG, PNG (Maksimal 2MB)
                        </div>
                    </div>

                    {{-- Tombol kirim --}}
                    <div class="flex justify-end items-center gap-6 pt-4">
                        <a href="{{ route('masyarakat.pengaduan.index') }}"
                            class="text-gray-400 font-bold hover:text-red-500 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="bg-green-600 text-white px-10 py-3 rounded-xl font-bold hover:bg-green-700 transition duration-300 shadow-lg shadow-green-100 transform hover:-translate-y-1">
                            Kirim Aduan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
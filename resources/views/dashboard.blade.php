<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Banner sambutan --}}
            <div class="mb-8 p-8 bg-green-600 rounded-3xl shadow-lg text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h1 class="text-3xl font-bold mb-2">Selamat Datang di Smart Quick Report</h1>
                    <p class="text-green-50 text-lg opacity-90">Layanan Pengaduan Online Masyarakat Kabupaten Karawang
                    </p>

                    {{-- Tombol Call to Action --}}
                    <div class="mt-6">
                        <a href="{{ route('masyarakat.pengaduan.create') }}"
                            class="inline-flex items-center px-6 py-3 bg-white text-green-700 font-bold rounded-xl shadow hover:bg-green-50 transition duration-150">
                            + Buat Pengaduan Sekarang
                        </a>
                    </div>
                </div>
            </div>

            {{-- Card ketentuan laporan pengaduan --}}
            <div class="mb-8 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                    <span class="w-1.5 h-6 bg-amber-500 rounded-full mr-3"></span>
                    Ketentuan Laporan Pengaduan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Foto --}}
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="text-2xl mb-2">📸</div>
                        <h4 class="font-bold text-gray-800 text-sm mb-1">Dokumentasi </h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Kirim dokumentasi aduan. Sistem akan otomatis
                            mendeteksi lokasi koordinat melalui GPS foto Anda.</p>
                    </div>

                    {{--Deskripsi --}}
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="text-2xl mb-2">✍️</div>
                        <h4 class="font-bold text-gray-800 text-sm mb-1">Deskripsi Jelas</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Jelaskan keluhan dengan bahasa yang sopan dan
                            jelas agar mudah diproses oleh petugas.</p>
                    </div>

                    {{-- Privasi --}}
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="text-2xl mb-2">🔒</div>
                        <h4 class="font-bold text-gray-800 text-sm mb-1">Privasi Aman</h4>
                        <p class="text-xs text-gray-500 leading-relaxed">Identitas Anda dijamin kerahasiaannya dan hanya
                            digunakan untuk keperluan validasi laporan.</p>
                    </div>
                </div>
            </div>

            {{-- Alur kerja SQR --}}
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm overflow-hidden relative">
                <h4 class="text-xl font-bold text-gray-800 mb-8 flex items-center">
                    <span class="w-2 h-8 bg-green-600 rounded-full mr-3"></span>
                    Alur Kerja SQR
                </h4>

                {{-- 4  --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    {{-- Langkah 1 --}}
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-3xl mb-2 block">📝</span>
                        <p class="font-bold text-gray-800 text-sm">1. Input Aduan</p>
                        <p class="text-[11px] text-gray-500 mt-1">Tulis keluhan Anda dengan lengkap melalui form yang
                            tersedia.</p>
                    </div>

                    {{-- Langkah 2 --}}
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-3xl mb-2 block">🔍</span>
                        <p class="font-bold text-gray-800 text-sm">2. Validasi</p>
                        <p class="text-[11px] text-gray-500 mt-1">Tim petugas memvalidasi data laporan dan validasi ke
                            lapangan.</p>
                    </div>

                    {{-- Langkah 3 --}}
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-3xl mb-2 block">⚙️</span>
                        <p class="font-bold text-gray-800 text-sm">3. Tindak Lanjut</p>
                        <p class="text-[11px] text-gray-500 mt-1">Laporan diteruskan ke instansi terkait untuk
                            ditindaklanjuti.</p>
                    </div>

                    {{-- Langkah 4 --}}
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-3xl mb-2 block">✅</span>
                        <p class="font-bold text-gray-800 text-sm">4. Selesai</p>
                        <p class="text-[11px] text-gray-500 mt-1">Pengaduan selesai dan Anda memberikan feedback</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
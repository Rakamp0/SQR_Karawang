<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 p-8 bg-gradient-to-r from-green-600 to-emerald-500 rounded-3xl shadow-xl shadow-green-200 relative overflow-hidden">
                <div class="relative z-10">
                    <h1 class="text-3xl font-black text-white mb-2 ">Selamat Datang di Smart Quick Report</h1>
                    <p class="text-green-50 text-lg opacity-90 font-medium">Layanan Pengaduan Online Masyarakat Kabupaten Karawang</p>
                    <p class="text-green-50 text-lg opacity-90 font-medium">Suara Anda membangun Karawang yang lebih baik. Ada keluhan hari ini?</p>
                    <div class="mt-6">
                        <a href="{{ route('masyarakat.pengaduan.create') }}" class="inline-flex items-center px-6 py-3 bg-white text-green-700 font-bold rounded-xl shadow-sm hover:bg-green-50 transition ease-in-out duration-150 group">
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Buat Pengaduan Sekarang
                        </a>
                    </div>
                </div>
                <div class="absolute right-0 bottom-0 opacity-20 transform translate-x-1/4 translate-y-1/4">
                    <svg class="w-80 h-80 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29L5.21 21L12 18L18.79 21L19.5 20.29L12 2Z"/></svg>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center">
                    <div class="p-4 bg-yellow-50 text-yellow-600 rounded-xl mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Menunggu</p>
                        <h3 class="text-2xl font-black text-gray-800">5 Aduan</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center">
                    <div class="p-4 bg-blue-50 text-blue-600 rounded-xl mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Diproses</p>
                        <h3 class="text-2xl font-black text-gray-800">2 Aduan</h3>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center">
                    <div class="p-4 bg-green-50 text-green-600 rounded-xl mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Selesai</p>
                        <h3 class="text-2xl font-black text-gray-800">12 Aduan</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                <h4 class="text-xl font-black text-gray-800 mb-6 flex items-center">
                    <span class="w-2 h-8 bg-green-600 rounded-full mr-3"></span>
                    Alur Pengaduan Karawang
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold mx-auto mb-3">1</div>
                        <p class="text-sm font-bold text-gray-700">Tulis Laporan</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold mx-auto mb-3">2</div>
                        <p class="text-sm font-bold text-gray-700">Validasi</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold mx-auto mb-3">3</div>
                        <p class="text-sm font-bold text-gray-700">Proses Tindaklanjut</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center font-bold mx-auto mb-3">4</div>
                        <p class="text-sm font-bold text-gray-700">Feedback</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
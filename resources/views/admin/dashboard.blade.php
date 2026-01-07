<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header Dashboard --}}
            <div class="mb-8">
                
                {{-- Jika yang login adalah instansi --}}
                @if(Auth::guard('instansi')->check())
                    <h2 class="text-3xl font-extrabold text-green-900 tracking-tight">
                        {{-- Ambil nama instansi dari data login --}}
                        Dashboard {{ Auth::guard('instansi')->user()->Nama_Instansi }} 🏢
                    </h2>
                    <p class="text-gray-500 mt-1">
                        Selamat datang! Silakan pantau dan tindak lanjuti laporan masyarakat yang masuk.
                    </p>
                
                {{-- Jika yang login adalah admin/petugas --}}
                @else
                    <h2 class="text-3xl font-extrabold text-green-900 tracking-tight">
                        Dashboard Admin 👮‍♂️
                    </h2>
                    <p class="text-gray-500 mt-1">
                        Selamat datang kembali! Berikut adalah Aduan dan Thread hari ini.
                    </p>
                @endif
            </div>

            {{-- Grid card aduan dan thread --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                
                {{-- Card 1: Pengaduan, muncul untuk semua --}}
                <div class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-blue-700 p-8 rounded-2xl text-white shadow-xl transition-all duration-300 hover:scale-[1.02] hover:shadow-blue-200">
                    
                    {{-- Dekorasi Latar Belakang (Lingkaran Blur) --}}
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <h3 class="text-blue-100 font-semibold uppercase tracking-wider text-sm">Total Pengaduan Masuk</h3>
                            {{-- Menampilkan angka total dari controller pengaduan/ --}}
                            <p class="text-5xl font-black mt-2 tracking-tight">{{ $totalAduan }}</p>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-md">
                            {{-- Ikon Dokumen --}}
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-8 relative z-10">
                        <a href="{{ route('admin.pengaduan') }}" class="inline-flex items-center gap-2 bg-white text-blue-700 px-5 py-2.5 rounded-xl font-bold text-sm transition hover:bg-blue-50">
                            Kelola Laporan
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Card 2: Thread, muncul hanya di admin/petugas --}}
                @if(Auth::guard('petugas')->check())
                    <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-emerald-600 p-8 rounded-2xl text-white shadow-xl transition-all duration-300 hover:scale-[1.02] hover:shadow-green-200">
                        
                        {{-- Dekorasi Latar Belakang --}}
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>

                        <div class="relative z-10 flex justify-between items-start">
                            <div>
                                <h3 class="text-green-100 font-semibold uppercase tracking-wider text-sm">Diskusi Warga (Thread)</h3>
                                {{-- Menampilkan angka total thread --}}
                                <p class="text-5xl font-black mt-2 tracking-tight">{{ $totalThread }}</p>
                            </div>
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-md">
                                {{-- Ikon chat --}}
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                </svg>
                            </div>
                        </div>

                        <div class="mt-8 relative z-10">
                            <a href="{{ route('admin.thread') }}" class="inline-flex items-center gap-2 bg-white text-green-700 px-5 py-2.5 rounded-xl font-bold text-sm transition hover:bg-green-50">
                                Kelola Forum
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endif

            </div>
            
        </div>
    </div>
</x-app-layout>
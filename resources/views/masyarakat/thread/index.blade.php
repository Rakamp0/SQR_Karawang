<x-app-layout>
    {{-- Header halaman dan tombol buat thread --}}
    <x-slot name="header">
        <div class="flex justify-between items-center">
            {{-- Judul halaman --}}
            <h2 class="font-black text-2xl text-green-800 leading-tight flex items-center">
                <span class="w-1.5 h-8 bg-green-600 rounded-full mr-3"></span>
                Thread
            </h2>
            
            {{-- Tombol "Buat Thread" --}}
            <a href="{{ route('masyarakat.thread.create') }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-green-100 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Buat Thread
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                
                {{-- Looping data thread --}}
                @forelse($threads as $t)
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-6 hover:shadow-md hover:border-green-100 transition-all duration-300 group">
                    
                    {{-- Jika ada gambar --}}
                    @if($t->Gambar_Thread)
                    <div class="flex-shrink-0">
                        <div class="overflow-hidden rounded-2xl w-full md:w-40 h-40 shadow-sm border border-gray-100">
                            {{-- Menampilkan gambar thread dari folder public/gambar_thread --}}
                            <img src="{{ asset('gambar_thread/' . $t->Gambar_Thread) }}" 
                                 class="object-cover w-full h-full transform group-hover:scale-110 transition duration-500">
                        </div>
                    </div>
                    @endif

                    {{-- Bagian konten --}}
                    <div class="flex-grow flex flex-col">
                        {{-- Header Postingan (avatar, nama, tanggal) --}}
                        <div class="flex items-center mb-3">
                            {{-- Avatar icon user --}}
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3 text-green-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                            </div>
                            
                            {{-- Nama penulis --}}
                            <span class="font-black text-green-700 uppercase text-xs tracking-wider">{{ $t->masyarakat->Nama_Masyarakat }}</span>
                            
                            <span class="mx-3 text-gray-300">•</span>
                            
                            {{-- Tanggal Posting (Format: 27 Desember 2025) --}}
                            <span class="text-xs font-bold text-gray-400 italic">
                                {{ \Carbon\Carbon::parse($t->Tanggal)->translatedFormat('d F Y') }}
                            </span>
                        </div>
                        
                        {{-- Isi thread --}}
                        <div class="flex-grow p-5 bg-gray-50/50 rounded-2xl border border-transparent group-hover:border-green-100 group-hover:bg-white transition-all duration-300">
                            <p class="text-gray-700 font-medium leading-relaxed">
                                {{ $t->Isi_Thread }}
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                
                {{-- Jika belum ada thread --}}
                <div class="bg-white p-20 text-center rounded-3xl border-2 border-dashed border-gray-200">
                    <div class="flex flex-col items-center">
                        <div class="bg-gray-50 p-4 rounded-full mb-4">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-black text-lg">Belum ada thread tersedia.</p>
                        <p class="text-gray-400 text-sm">Ayo mulai obrolan positif hari ini!</p>
                    </div>
                </div>
                @endforelse
                
            </div>
        </div>
    </div>
</x-app-layout>
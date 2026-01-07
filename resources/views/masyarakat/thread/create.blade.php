<x-app-layout>
    {{-- Header judul dan halaman --}}
    <x-slot name="header">
        <div class="flex items-center">
            {{-- Tombol back --}}
            <a href="{{ route('masyarakat.thread.index') }}" class="mr-4 text-gray-400 hover:text-green-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-black text-2xl text-green-800 leading-tight">
                Tambah thread
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            {{-- Card putih utama --}}
            <div class="bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-gray-100">
                
                {{-- enctype="multipart/form-data" untuk upload gambar --}}
                <form action="{{ route('masyarakat.thread.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf 
                    
                    {{-- Input isi thread --}}
                    <div>
                        <label class="block font-black text-green-800 uppercase tracking-wider text-xs mb-2">
                            Apa yang ingin Anda ceritakan?
                        </label>
                        <textarea name="isi" rows="6" 
                            class="w-full border-gray-200 rounded-2xl shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition duration-200 placeholder-gray-400" 
                            placeholder="Tuliskan isi thread atau topik diskusi Anda di sini..." required>{{ old('isi') }}</textarea>
                    </div>

                    {{-- Input gambar(opsional) --}}
                    <div class="p-6 bg-green-50 rounded-2xl border border-green-100">
                        <label class="block font-black text-green-700 uppercase tracking-wider text-xs mb-2">
                            Tambah Gambar (Opsional)
                        </label>
                        <input type="file" name="gambar" 
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-green-600 file:text-white hover:file:bg-green-700 transition-all cursor-pointer">
                        <p class="mt-2 text-xs text-green-600/70 font-medium">
                            Format: JPG, JPEG, PNG (Maksimal 2MB)
                        </p>
                    </div>

                    {{-- Tombol batal dan kirim --}}
                    <div class="flex justify-end items-center gap-6 pt-4 border-t border-gray-50">
                        {{-- Tombol batal --}}
                        <a href="{{ route('masyarakat.thread.index') }}" class="text-gray-400 font-bold hover:text-red-500 transition-colors">
                            Batal
                        </a>
                        {{-- Tombol kirim --}}
                        <button type="submit" 
                            class="bg-green-600 text-white px-10 py-3 rounded-xl font-bold hover:bg-green-700 transition-all duration-300 shadow-lg shadow-green-100 transform hover:-translate-y-1">
                            Tambahkan Thread
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    {{-- Header --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Card profil --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg flex flex-col md:flex-row gap-8">

                {{-- Kolom kiri, foto dan poin --}}
                <div
                    class="w-full md:w-1/3 flex flex-col items-center border-b md:border-b-0 md:border-r border-gray-200 pb-6 md:pb-0 md:pr-6">

                    {{-- Foto Profil --}}
                    <div class="relative">
                        <div
                            class="w-40 h-40 rounded-full overflow-hidden bg-gray-200 shadow-lg mb-4 flex items-center justify-center border-4 border-green-500">
                            {{-- Cek apakah user punya foto profil --}}
                            @if(Auth::user()->foto_profile)
                                <img src="{{ asset('storage/' . Auth::user()->foto_profile) }}" alt="Foto Profil"
                                    class="w-full h-full object-cover">
                            @else
                                {{-- Jika tidak ada foto, tampilkan emoji --}}
                                <span class="text-6xl text-gray-400">👤</span>
                            @endif
                        </div>
                    </div>

                    {{-- Nama dan username --}}
                    <h3 class="text-xl font-bold text-gray-900 text-center">{{ Auth::user()->Nama_Masyarakat }}</h3>
                    <p class="text-sm text-gray-500 text-center mb-6">@ {{ Auth::user()->Username_Msy }}</p>

                    {{-- Kartu poin SQR --}}
                    <div
                        class="w-full bg-gradient-to-r from-green-400 to-green-600 rounded-2xl p-4 text-white shadow-md relative overflow-hidden text-center transform transition hover:scale-105 duration-300">
                        <div class="relative z-10">
                            <p class="text-green-100 text-xs font-bold uppercase tracking-widest mb-1">Total SQR Points
                            </p>
                            <h3 class="text-4xl font-black">
                                {{ Auth::user()->Poin ?? 0 }}
                                <span class="text-lg font-medium opacity-80">pts</span>
                            </h3>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mt-6 flex gap-2 justify-center">
                        <span
                            class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">Masyarakat</span>
                        <span
                            class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold">Terverifikasi</span>
                    </div>
                </div>

                {{-- kolom kanan, detail informasi --}}
                <div class="w-full md:w-2/3">
                    <div class="flex justify-between items-center border-b pb-4 mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Informasi Pribadi</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Data NIK --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">NIK
                                (Nomor Induk Kependudukan)</label>
                            <p class="text-gray-900 font-bold text-lg">{{ Auth::user()->NIK_Masyarakat }}</p>
                        </div>

                        {{-- Data email --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat
                                Email</label>
                            <p class="text-gray-900 font-bold text-lg">{{ Auth::user()->Email_Masyarakat }}</p>
                        </div>

                        {{-- Data alamat --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat
                                Lengkap</label>
                            <p
                                class="text-gray-900 font-medium bg-gray-50 p-4 rounded-xl border border-gray-100 leading-relaxed">
                                {{ Auth::user()->Alamat_Masyarakat }}
                            </p>
                        </div>
                    </div>

                    {{-- Tombol logout --}}
                    <div class="mt-10 border-t pt-6">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-red-500 hover:text-red-700 font-bold text-sm flex items-center gap-2 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Log Out 
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
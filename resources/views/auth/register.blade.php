<x-guest-layout>
    {{-- Card tunggal yang bersih --}}
    <div class="bg-white px-8 py-10 md:px-10 md:py-12 rounded-[3.5rem] shadow-sm border border-gray-100">
        
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-3 mb-6">
                <span class="text-3xl font-black text-green-600 tracking-tighter">SQR</span>
                <div class="h-8 w-px bg-green-600/20 mx-1"></div>
                <div class="flex flex-col text-left text-green-600">
                    <span class="text-[10px] font-bold uppercase leading-none tracking-tight">Smart</span>
                    <span class="text-[10px] font-bold uppercase leading-none mt-1 tracking-tighter">Quick Report</span>
                </div>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Buat Akun Baru</h2>
            <p class="text-sm text-gray-400 font-medium mt-2">Lengkapi data untuk register</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block font-bold text-green-800 uppercase tracking-[0.1em] text-[10px] mb-2 ml-1">Nama Lengkap</label>
                    <input id="Nama_Masyarakat" class="block w-full px-5 py-4 bg-[#f0f7ff] border-transparent rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-500/10 focus:bg-white transition-all duration-300 text-sm font-medium text-gray-700" type="text" name="Nama_Masyarakat" :value="old('Nama_Masyarakat')" required autofocus placeholder="Masukan Nama..." />
                    <x-input-error :messages="$errors->get('Nama_Masyarakat')" class="mt-2 text-xs" />
                </div>

                <div>
                    <label class="block font-bold text-green-800 uppercase tracking-[0.1em] text-[10px] mb-2 ml-1">Username</label>
                    <input id="Username_Msy" class="block w-full px-5 py-4 bg-[#f0f7ff] border-transparent rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-500/10 focus:bg-white transition-all duration-300 text-sm font-medium text-gray-700" type="text" name="Username_Msy" :value="old('Username_Msy')" required placeholder="Masukan Username..." />
                    <x-input-error :messages="$errors->get('Username_Msy')" class="mt-2 text-xs" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block font-bold text-green-800 uppercase tracking-[0.1em] text-[10px] mb-2 ml-1">NIK (KTP)</label>
                    <input id="NIK_Masyarakat" class="block w-full px-5 py-4 bg-[#f0f7ff] border-transparent rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-500/10 focus:bg-white transition-all duration-300 text-sm font-medium text-gray-700" type="number" name="NIK_Masyarakat" :value="old('NIK_Masyarakat')" required placeholder="Masukan NIK..." />
                    <x-input-error :messages="$errors->get('NIK_Masyarakat')" class="mt-2 text-xs" />
                </div>

                <div>
                    <label class="block font-bold text-green-800 uppercase tracking-[0.1em] text-[10px] mb-2 ml-1">Alamat Email</label>
                    <input id="Email_Masyarakat" class="block w-full px-5 py-4 bg-[#f0f7ff] border-transparent rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-500/10 focus:bg-white transition-all duration-300 text-sm font-medium text-gray-700" type="email" name="Email_Masyarakat" :value="old('Email_Masyarakat')" required placeholder="Masukan Email..." />
                    <x-input-error :messages="$errors->get('Email_Masyarakat')" class="mt-2 text-xs" />
                </div>
            </div>

            <div>
                <label class="block font-bold text-green-800 uppercase tracking-[0.1em] text-[10px] mb-2 ml-1">Alamat Lengkap</label>
                <textarea id="Alamat_Masyarakat" name="Alamat_Masyarakat" rows="3" class="block w-full px-5 py-4 bg-[#f0f7ff] border-transparent rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-500/10 focus:bg-white transition-all duration-300 text-sm font-medium text-gray-700" required placeholder="Tuliskan alamat lengkap...">{{ old('Alamat_Masyarakat') }}</textarea>
                <x-input-error :messages="$errors->get('Alamat_Masyarakat')" class="mt-2 text-xs" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block font-bold text-green-800 uppercase tracking-[0.1em] text-[10px] mb-2 ml-1">Kata Sandi</label>
                    <input id="Password_Msy" class="block w-full px-5 py-4 bg-[#f0f7ff] border-transparent rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-500/10 focus:bg-white transition-all duration-300 text-sm font-medium text-gray-700" type="password" name="Password_Msy" required autocomplete="new-password" placeholder="Masukan Password..." />
                    <x-input-error :messages="$errors->get('Password_Msy')" class="mt-2 text-xs" />
                </div>

                <div>
                    <label class="block font-bold text-green-800 uppercase tracking-[0.1em] text-[10px] mb-2 ml-1">Konfirmasi Sandi</label>
                    <input id="Password_Msy_confirmation" class="block w-full px-5 py-4 bg-[#f0f7ff] border-transparent rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-500/10 focus:bg-white transition-all duration-300 text-sm font-medium text-gray-700" type="password" name="Password_Msy_confirmation" required placeholder="Konfirmasi Password..." />
                    <x-input-error :messages="$errors->get('Password_Msy_confirmation')" class="mt-2 text-xs" />
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-[#1db45a] hover:bg-[#169d4e] text-white font-bold py-4 rounded-2xl shadow-lg shadow-green-100 transition-all duration-300 transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-sm">
                    Daftar
                </button>
            </div>

            <div class="text-center mt-6">
                <p class="text-xs text-gray-400 font-medium">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="text-green-600 font-bold hover:underline decoration-2 underline-offset-8 ml-1">
                        Masuk Disini
                    </a>
                </p>
            </div>
        </form>
    </div>

    <p class="mt-12 text-center text-[10px] text-gray-300 font-medium uppercase tracking-[0.4em]">
        &copy; 2025 SQR KARAWANG - LAYANAN PENGADUAN CEPAT
    </p>
</x-guest-layout>
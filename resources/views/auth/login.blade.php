<x-guest-layout>
    {{-- Card utama SQR --}}
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
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Selamat Datang Kembali!</h2>
            <p class="text-sm text-gray-400 font-medium mt-2">Silakan masuk ke akun Anda</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block font-bold text-green-800 uppercase tracking-[0.1em] text-[10px] mb-2 ml-1">Masuk Sebagai</label>
                <select name="role" class="block w-full px-5 py-4 bg-[#f0f7ff] border-transparent rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-500/10 focus:bg-white transition-all duration-300 text-sm font-medium text-gray-700 appearance-none">
                    <option value="masyarakat" {{ old('role') == 'masyarakat' ? 'selected' : '' }}>Masyarakat</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin / Petugas</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2 text-xs" />
            </div>

            <div>
                <label class="block font-bold text-green-800 uppercase tracking-[0.1em] text-[10px] mb-2 ml-1">Alamat Email</label>
                <input id="email" 
                       name="Email_Masyarakat" 
                       value="{{ old('Email_Masyarakat') }}" 
                       class="block w-full px-5 py-4 bg-[#f0f7ff] border-transparent rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-500/10 focus:bg-white transition-all duration-300 text-sm font-medium text-gray-700" 
                       type="email" 
                       required 
                       autofocus 
                       placeholder="nama@email.com" />
                <x-input-error :messages="$errors->get('Email_Masyarakat')" class="mt-2 text-xs" />
            </div>

            <div>
                <label class="block font-bold text-green-800 uppercase tracking-[0.1em] text-[10px] mb-2 ml-1">Kata Sandi</label>
                <input id="password" 
                       name="Password_Msy" 
                       class="block w-full px-5 py-4 bg-[#f0f7ff] border-transparent rounded-2xl focus:border-green-500 focus:ring-4 focus:ring-green-500/10 focus:bg-white transition-all duration-300 text-sm font-medium text-gray-700" 
                       type="password" 
                       required 
                       placeholder="••••••••" />
                <x-input-error :messages="$errors->get('Password_Msy')" class="mt-2 text-xs" />
            </div>

            <div class="flex items-center justify-between px-1">
                <label class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500/20 shadow-sm" name="remember">
                    <span class="ml-2 text-xs font-medium text-gray-400">Ingat Saya</span>
                </label>
                
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-green-600 hover:text-green-700 transition-colors" href="{{ route('password.request') }}">
                        Lupa Sandi?
                    </a>
                @endif
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full bg-[#1db45a] hover:bg-[#169d4e] text-white font-bold py-4 rounded-2xl shadow-lg shadow-green-100 transition-all duration-300 transform hover:-translate-y-1 active:scale-95 uppercase tracking-widest text-sm">
                    Masuk Sekarang
                </button>
            </div>

            <div class="text-center mt-6">
                <p class="text-xs text-gray-400 font-medium">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-green-600 font-bold hover:underline decoration-2 underline-offset-8 ml-1">
                        Daftar Disini
                    </a>
                </p>
            </div>
        </form>
    </div>

    <p class="mt-12 text-center text-[10px] text-gray-300 font-medium uppercase tracking-[0.4em]">
        &copy; 2025 SQR KARAWANG - LAYANAN PENGADUAN CEPAT
    </p>
</x-guest-layout>
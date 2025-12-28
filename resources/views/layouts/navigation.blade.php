<nav x-data="{ open: false }" class="bg-white border-b border-green-100 sticky top-0 z-50 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    @php
                        $dashboardLink = Auth::guard('petugas')->check() ? route('admin.dashboard') : route('dashboard');
                    @endphp
                    <a href="{{ $dashboardLink }}" class="flex items-center gap-3 group transition-transform duration-200 hover:scale-105">
                        <span class="text-3xl font-black text-green-600 tracking-tighter">SQR</span>
                        <div class="h-8 w-px bg-green-600 mx-1"></div>
                        <div class="flex flex-col justify-center text-green-600">
                            <span class="text-xs font-bold uppercase leading-none">Smart</span>
                            <span class="text-xs font-bold uppercase leading-none mt-1 tracking-tighter">Quick Report</span>
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex font-bold">
                    @if(Auth::guard('petugas')->check())
                        {{-- MENU KHUSUS ADMIN --}}
                        {{-- Menambahkan class active untuk paksa warna hijau pada border bawah --}}
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')"
                            class="active:border-green-600 focus:border-green-600 transition duration-300"
                            style="{{ request()->routeIs('admin.dashboard') ? 'border-color: #16a34a; color: #16a34a;' : '' }}">
                            {{ __('Dashboard Admin') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.pengaduan')" :active="request()->routeIs('admin.pengaduan')"
                            class="active:border-green-600 focus:border-green-600 transition duration-300"
                            style="{{ request()->routeIs('admin.pengaduan') ? 'border-color: #16a34a; color: #16a34a;' : '' }}">
                            {{ __('Kelola Pengaduan') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.thread')" :active="request()->routeIs('admin.thread')"
                            class="active:border-green-600 focus:border-green-600 transition duration-300"
                            style="{{ request()->routeIs('admin.thread') ? 'border-color: #16a34a; color: #16a34a;' : '' }}">
                            {{ __('Kelola Forum') }}
                        </x-nav-link>
                    @else
                        {{-- MENU KHUSUS MASYARAKAT --}}
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                            class="active:border-green-600 focus:border-green-600 transition duration-300"
                            style="{{ request()->routeIs('dashboard') ? 'border-color: #16a34a; color: #16a34a;' : '' }}">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('masyarakat.pengaduan.index')" :active="request()->routeIs('masyarakat.pengaduan.*')"
                            class="active:border-green-600 focus:border-green-600 transition duration-300"
                            style="{{ request()->routeIs('masyarakat.pengaduan.*') ? 'border-color: #16a34a; color: #16a34a;' : '' }}">
                            {{ __('Pengaduan') }}
                        </x-nav-link>

                        <x-nav-link :href="route('masyarakat.thread.index')" :active="request()->routeIs('masyarakat.thread.*')"
                            class="active:border-green-600 focus:border-green-600 transition duration-300"
                            style="{{ request()->routeIs('masyarakat.thread.*') ? 'border-color: #16a34a; color: #16a34a;' : '' }}">
                            {{ __('Forum Diskusi') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-5 py-2.5 border border-green-200 text-sm font-bold rounded-full text-green-700 bg-green-50 hover:bg-green-600 hover:text-white transition duration-300">
                            <div class="uppercase tracking-tight">
                                {{ Auth::guard('petugas')->check() ? Auth::guard('petugas')->user()->Nama_Petugas : Auth::user()->Nama_Masyarakat }}
                            </div>
                            <div class="ml-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(!Auth::guard('petugas')->check())
                            <x-dropdown-link :href="route('profile.edit')" class="hover:bg-green-50">
                                {{ __('Profil Saya') }}
                            </x-dropdown-link>
                        @endif
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="text-red-600 font-bold hover:bg-red-50"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>
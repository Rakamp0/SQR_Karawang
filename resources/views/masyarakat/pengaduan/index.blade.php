<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-green-800 leading-tight flex items-center">
                <span class="w-2 h-8 bg-green-600 rounded-full mr-3"></span>
                {{ __('Riwayat Pengaduan Saya') }}
            </h2>
            <a href="{{ route('masyarakat.pengaduan.create') }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-green-200 transition-all duration-300 transform hover:-translate-y-1 flex items-center">
                <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Aduan Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('status'))
                <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center shadow-sm animate-fade-in">
                    <div class="p-2 bg-green-100 rounded-lg mr-3">
                        <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <span class="font-bold">{{ session('status') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="px-8 py-5 text-left text-xs font-black text-green-700 uppercase tracking-widest">Detail Laporan</th>
                                <th class="px-8 py-5 text-left text-xs font-black text-green-700 uppercase tracking-widest">Dokumentasi</th>
                                <th class="px-8 py-5 text-left text-xs font-black text-green-700 uppercase tracking-widest">Status Progress</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 bg-white">
                            @forelse($aduans as $aduan)
                                <tr class="hover:bg-green-50/40 transition duration-200 group">
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-gray-400 mb-1 italic">
                                                {{ \Carbon\Carbon::parse($aduan->Tanggal_Pengaduan)->format('d F Y') }}
                                            </span>
                                            <span class="text-lg font-bold text-gray-800 group-hover:text-green-700 transition-colors">
                                                {{ $aduan->Judul_Pengaduan }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        @if($aduan->dokumentasi)
                                            <div class="relative w-20 h-20 overflow-hidden rounded-2xl border-2 border-white shadow-md group-hover:rotate-2 transition-transform">
                                                <img src="{{ asset('dokumentasi/' . $aduan->dokumentasi) }}" 
                                                     class="w-full h-full object-cover"
                                                     alt="Dokumentasi">
                                            </div>
                                        @else
                                            <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center border border-dashed border-gray-200">
                                                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center">
                                            @php
                                                $statusClass = [
                                                    'Selesai' => 'bg-green-100 text-green-700 border-green-200',
                                                    'Diproses' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                    'Ditinjau' => 'bg-yellow-100 text-yellow-700 border-yellow-200'
                                                ][$aduan->Keterangan ?? 'Ditinjau'];
                                            @endphp
                                            <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-tighter border shadow-sm {{ $statusClass }}">
                                                {{ $aduan->Keterangan ?? 'Ditinjau' }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="p-6 bg-gray-50 rounded-full mb-4">
                                                <svg class="h-16 w-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 font-bold text-lg">Belum ada jejak laporan nih.</p>
                                            <p class="text-gray-400 text-sm mt-1">Laporan yang Anda buat akan muncul di sini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
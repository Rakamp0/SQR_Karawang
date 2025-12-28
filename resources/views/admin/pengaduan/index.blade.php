<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-green-900 tracking-tight">Moderasi Pengaduan</h2>
                    <p class="text-gray-500 mt-1">Kelola dan pantau semua laporan masuk dari masyarakat.</p>
                </div>
                <div class="flex gap-4">
                    <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100">
                        <span class="text-xs text-gray-400 uppercase font-bold tracking-wider">Total</span>
                        <p class="text-xl font-black text-green-600">{{ count($pengaduans) }}</p>
                    </div>
                </div>
            </div>
            
            {{-- Alert Sukses --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-200">
                                <th class="p-4 text-xs font-bold uppercase tracking-widest text-gray-500">Informasi Laporan</th>
                                <th class="p-4 text-xs font-bold uppercase tracking-widest text-gray-500 text-center">Status Saat Ini</th>
                                <th class="p-4 text-xs font-bold uppercase tracking-widest text-gray-500 text-center">Ubah Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pengaduans as $item)
                            <tr class="hover:bg-gray-50/80 transition-colors group">
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-900 group-hover:text-green-600 transition-colors line-clamp-1">
                                            {{ $item->Judul_Pengaduan }}
                                        </span>
                                        <span class="text-sm text-gray-500 mt-1 line-clamp-2 italic leading-relaxed">
                                            "{{ $item->Deskripsi }}"
                                        </span>
                                        <div class="mt-2 flex items-center text-[10px] text-gray-400 font-medium uppercase tracking-tighter">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            {{ \Carbon\Carbon::parse($item->Tanggal_Pengaduan)->format('d M Y') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    @php
                                        $status = $item->Keterangan;
                                        $badgeStyles = [
                                            'Ditinjau' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            'Sedang Diproses' => 'bg-yellow-50 text-yellow-600 border-yellow-100',
                                            'Selesai' => 'bg-green-50 text-green-600 border-green-100',
                                            'Ditolak' => 'bg-red-50 text-red-600 border-red-100',
                                        ];
                                        $currentStyle = $badgeStyles[$status] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                    @endphp

                                    {{-- Tanpa Bullet: Hanya teks tebal dengan background lembut --}}
                                    <span class="inline-flex items-center px-4 py-1 rounded-full text-[10px] font-black border uppercase tracking-widest {{ $currentStyle }}">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <form action="{{ route('admin.pengaduan.update', $item->Id_Pengaduan) }}" method="POST" class="inline-block">
                                        @csrf 
                                        @method('PATCH')
                                        <div class="relative">
                                            <select name="status" onchange="this.form.submit()" 
                                                class="appearance-none pr-8 pl-3 py-1.5 text-xs font-bold rounded-lg border-gray-200 bg-gray-50 text-gray-700 cursor-pointer focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                                                <option value="Ditinjau" {{ $item->Keterangan == 'Ditinjau' ? 'selected' : '' }}>Set Ditinjau</option>
                                                <option value="Sedang Diproses" {{ $item->Keterangan == 'Sedang Diproses' ? 'selected' : '' }}>Set Proses</option>
                                                <option value="Selesai" {{ $item->Keterangan == 'Selesai' ? 'selected' : '' }}>Set Selesai</option>
                                                <option value="Ditolak" {{ $item->Keterangan == 'Ditolak' ? 'selected' : '' }}>Set Tolak</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <p class="font-medium">Belum ada data pengaduan.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <p class="mt-6 text-center text-gray-400 text-xs">Sistem Pengaduan v1.0 • Smart Quick Report</p>
        </div>
    </div>
</x-app-layout>
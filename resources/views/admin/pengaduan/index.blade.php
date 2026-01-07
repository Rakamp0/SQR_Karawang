<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Kelola Pengaduan') }}
            </h2>

            {{-- Mengecek siapa yang login? --}}
            @if(Auth::guard('instansi')->check())
                {{-- Jika yang login instansi --}}
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-400">
                    Mode Instansi: {{ Auth::guard('instansi')->user()->Nama_Instansi }}
                </span>
            @elseif(Auth::guard('petugas')->check())
                {{-- Jika yang login petugas/admin --}}
                <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-500">
                    Mode Admin 
                </span>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Sistem Notifikasi --}}
            {{-- Muncul jika Controller mengirim pesan 'success' atau 'error' --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    
                    {{-- Tabel data pengaduan --}}
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Pelapor</th>
                                <th class="px-6 py-3">Judul & Isi</th>
                                <th class="px-6 py-3">Bukti</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Instansi Tujuan</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Looping data menampilkan semua laporan --}}
                            @foreach($pengaduans as $p)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                {{-- Tanggal Diformat jadi "01 Jan 2025" --}}
                                <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($p->Tanggal_Pengaduan)->format('d M Y') }}</td>
                                
                                {{-- Info Pelapor Nama & NIK --}}
                                <td class="px-6 py-4">
                                    <div class="font-bold">{{ $p->masyarakat->Nama_Masyarakat ?? 'Guest' }}</div>
                                    <div class="text-xs">{{ $p->masyarakat->NIK_Masyarakat ?? '-' }}</div>
                                </td>

                                {{-- Judul & Deskripsi max 50 huruf --}}
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800">{{ $p->Judul_Pengaduan }}</div>
                                    <div class="font-light text-gray-800">{{ $p->Kategori }}</div>
                                    <div class="text-xs mt-1">{{ Str::limit($p->Deskripsi, 50) }}</div>
                                </td>

                                {{-- Foto Bukti --}}
                                <td class="px-6 py-4">
                                    @if($p->dokumentasi)
                                        <a href="{{ url('img-proxy/'.$p->dokumentasi) }}" target="_blank" class="text-blue-600 hover:underline text-xs">Lihat Foto</a>
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- status warna-warni --}}
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded text-xs font-bold
                                        {{-- Logika Warna: Hijau(Selesai), Merah(Ditolak), Biru(Diproses), Ungu(Valid), Kuning(Ditinjau) --}}
                                        {{ $p->Keterangan == 'Selesai' ? 'bg-green-100 text-green-700' : 
                                          ($p->Keterangan == 'Ditolak' ? 'bg-red-100 text-red-700' : 
                                          ($p->Keterangan == 'Diproses' ? 'bg-blue-100 text-blue-700' : 
                                          ($p->Keterangan == 'Valid' ? 'bg-indigo-100 text-indigo-700' : 'bg-yellow-100 text-yellow-700'))) }}">
                                        {{ $p->Keterangan }}
                                    </span>
                                </td>

                                {{-- Instansi tujuan jika sudah dipilih admin/petugas --}}
                                <td class="px-6 py-4 text-xs">
                                    {{ $p->instansi->Nama_Instansi ?? '-' }}
                                </td>

                                {{-- Kolom aksi (Logika Utama) --}}
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.pengaduan.update', $p->Id_Pengaduan) }}" method="POST" class="flex flex-col gap-2">
                                        @csrf
                                        @method('PATCH')

                                        {{-- Bagian admin/petugas --}}
                                        @if(Auth::guard('petugas')->check())
                                            
                                            {{-- Status aduan 'Ditinjau' --}}
                                            @if($p->Keterangan == 'Ditinjau')
                                                
                                                {{-- Memilih dinas terkait --}}
                                                <select name="id_instansi" class="text-xs border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 w-full mb-1" required>
                                                    <option value="">-- Pilih Dinas --</option>
                                                    @foreach($listInstansi as $dinas)
                                                        <option value="{{ $dinas->Id_Instansi }}">{{ $dinas->Nama_Instansi }}</option>
                                                    @endforeach
                                                </select>
                                                
                                                {{-- Tombol validasi Kirim ke instansi atau Tolak --}}
                                                <div class="flex gap-1">
                                                    <button type="submit" name="status" value="Valid" class="flex-1 text-white bg-green-600 hover:bg-green-700 font-medium rounded text-xs px-2 py-1">
                                                        Validasi
                                                    </button>
                                                    <button type="submit" name="status" value="Ditolak" class="flex-1 text-white bg-red-600 hover:bg-red-700 font-medium rounded text-xs px-2 py-1">
                                                        Tolak
                                                    </button>
                                                </div>
                                            @else
                                                {{-- Status Menunggu Instansi --}}
                                                <span class="text-xs text-center text-gray-400 block italic">Menunggu Instansi</span>
                                            @endif
                                        @endif

                                        {{-- Zona instansi --}}
                                        @if(Auth::guard('instansi')->check())
                                            
                                            {{-- Tombol Diproses aduan yang valid --}}
                                            @if($p->Keterangan == 'Valid')
                                                <button type="submit" name="status" value="Diproses" class="w-full text-white bg-blue-600 hover:bg-blue-700 font-medium rounded text-xs px-3 py-1">
                                                    Proses Laporan
                                                </button>
                                            
                                            {{-- Tombol Selesaikan setelah status Dikerjakan --}}
                                            @elseif($p->Keterangan == 'Diproses')
                                                <button type="submit" name="status" value="Selesai" class="w-full text-white bg-green-600 hover:bg-green-700 font-medium rounded text-xs px-3 py-1">
                                                    Selesaikan
                                                </button>
                                            
                                            {{-- Teks Selesai --}}
                                            @else
                                                <span class="text-xs text-center text-gray-400 block italic">Selesai</span>
                                            @endif
                                        @endif

                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            
                            {{-- Jika belum ada data sama sekali --}}
                            @if($pengaduans->isEmpty())
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500 italic">
                                    Belum ada pengaduan yang masuk.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
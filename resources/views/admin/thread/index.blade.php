<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-green-900 tracking-tight">Moderasi Forum</h2>
                    <p class="text-gray-500 mt-1">Pantau dan bersihkan konten forum yang tidak sesuai ketentuan.</p>
                </div>
                <div class="bg-white px-5 py-2 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                    <span class="text-sm font-bold text-gray-700">{{ $threads->count() }} Thread Aktif</span>
                </div>
            </div>

            {{-- Alert Section --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-xl shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-200">
                                <th class="p-4 text-xs font-bold uppercase tracking-widest text-gray-500">Isi Konten Thread</th>
                                <th class="p-4 text-xs font-bold uppercase tracking-widest text-gray-500">Penulis</th>
                                <th class="p-4 text-xs font-bold uppercase tracking-widest text-gray-500">Waktu Posting</th>
                                <th class="p-4 text-xs font-bold uppercase tracking-widest text-gray-500 text-center">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($threads as $thread)
                                <tr class="hover:bg-gray-50/80 transition-colors group">
                                    <td class="p-4 max-w-md">
                                        <div class="text-gray-800 text-sm leading-relaxed line-clamp-3 italic">
                                            "{{ $thread->Isi_Thread }}"
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex items-center gap-3">
                                            {{-- Avatar Inisial --}}
                                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-xs shadow-sm">
                                                {{ substr($thread->masyarakat->Nama_Masyarakat ?? 'U', 0, 1) }}
                                            </div>
                                            <span class="text-sm font-bold text-gray-700">
                                                {{ $thread->masyarakat->Nama_Masyarakat ?? 'User #'.$thread->Id_Masyarakat }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm text-gray-700 font-medium">
                                                {{ \Carbon\Carbon::parse($thread->Tanggal)->format('d M Y') }}
                                            </span>
                                            <span class="text-[10px] text-gray-400 uppercase tracking-tighter">
                                                {{ \Carbon\Carbon::parse($thread->Tanggal)->diffForHumans() }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="flex justify-center">
                                            <form action="{{ route('admin.thread.delete', $thread->Id_Thread) }}" method="POST" 
                                                onsubmit="return confirm('Tindakan ini tidak dapat dibatalkan. Hapus thread ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 text-xs font-bold rounded-xl border border-red-100 hover:bg-red-600 hover:text-white hover:shadow-lg hover:shadow-red-100 transition-all duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus Konten
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="p-4 bg-gray-50 rounded-full mb-4">
                                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 font-medium text-lg">Forum masih bersih</p>
                                            <p class="text-gray-400 text-sm">Belum ada thread yang dilaporkan atau dibuat.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <p class="mt-8 text-center text-gray-400 text-xs tracking-widest uppercase font-medium">
                SQR Forum Moderation Engine
            </p>
        </div>
    </div>
</x-app-layout>
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use Illuminate\Support\Facades\File; // Import Facade File buat urusan hapus-menghapus

class ThreadController extends Controller
{

    // Admin bisa melihat semua thread
    public function index()
    {

        $data_threads = [];

        // Ambil data thread dengan masyarakat yang membuat threadnya
        $data_threads = Thread::with('masyarakat')
            ->orderBy('Tanggal', 'asc')
            ->get();

        // Oper ke View
        // Tampilkan di view
        return view('admin.thread.index', [
            'threads' => $data_threads
        ]);
    }

    // Hapus thread
    public function destroy($id)
    {
    
        // Cari data thread berdasarkan 'Id_thread'
        $data_thread = Thread::where('Id_Thread', $id)->firstOrFail();

        // Hapus gambar
        // Cek, apakah thread memiliki gambar?
        $nama_gambar = $data_thread->Gambar_Thread;
        if ($nama_gambar != null) {

            // Cari lokasi file asli ada dimana?
            $lokasi_file = public_path('dokumentasi/' . $nama_gambar);

            // Ceka apakah filenya ada?
            if (File::exists($lokasi_file)) {
                // Hapus jika ada
                File::delete($lokasi_file);
            }
        }

        // Hapus data dari database
        // Setelah tidak ada gambar, hapus datanya
        $data_thread->delete();

        return back()->with('success', 'Konten thread berhasil dihapus dari sistem!');
    }
}
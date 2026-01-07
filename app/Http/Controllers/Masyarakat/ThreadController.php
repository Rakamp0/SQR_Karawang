<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThreadController extends Controller
{
    // Halaman utama thread
    public function index()
    {
        // Mengambil data thread dengan penulisnya (masyarakat)
        $threads = Thread::with('masyarakat')
            ->orderBy('Tanggal', 'asc')
            ->get();

        return view('masyarakat.thread.index', compact('threads'));
    }

    // Halaman form buat thread
    public function create()
    {
        return view('masyarakat.thread.create');
    }

    // Buat thread
    public function store(Request $request)
    {
        // Validasi, 'isi' tidak boleh kosong, gambar boleh
        $request->validate([
            'isi' => 'required|min:5', // Minimal 5 char
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Ambil data masyarakat yang sedang login
        $user = Auth::guard('web')->user();

        DB::beginTransaction(); // Simpan sementara
        try {
            $nama_gambar = null;

            // Cek apakah ada gambar?
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $nama_gambar = time() . "_" . $file->getClientOriginalName();
                // Simpan ke folder khusus thread
                $file->move(public_path('gambar_thread'), $nama_gambar);
            }

            // Simpan ke database
            Thread::create([
                'Id_Masyarakat' => $user->Id_Masyarakat,
                'Isi_Thread' => $request->isi,
                'Gambar_Thread' => $nama_gambar, 
                'Tanggal' => now()
            ]);

            DB::commit(); // Simpan permanen

            return redirect()->route('masyarakat.thread.index')
                ->with('status', 'Thread berhasil dibuat');

        // Jika terjadi error
        } catch (\Exception $e) {
            DB::rollBack(); 
            return back()->withInput()->with('error', 'Gagal posting: ' . $e->getMessage());
        }
    }
}
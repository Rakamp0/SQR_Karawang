<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThreadController extends Controller
{
    /**
     * Tampilan Daftar Thread (Forum)
     */
    public function index()
    {
        // Mengambil data thread beserta relasi masyarakat
        $threads = Thread::with('masyarakat')
            ->orderBy('Tanggal', 'desc') 
            ->get();

        return view('masyarakat.thread.index', compact('threads'));
    }

    /**
     * Tampilan Form Buat Thread
     */
    public function create()
    {
        return view('masyarakat.thread.create');
    }

    /**
     * Proses Simpan ke Tabel Thread
     */
    public function store(Request $request)
    {
        // 1. Validasi Input sesuai atribut 'name' di blade
        $request->validate([
            'isi' => 'required|min:5',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // 2. Ambil User secara fleksibel (guard masyarakat atau default)
        $user = Auth::guard('masyarakat')->user() ?? Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Sesi berakhir, silakan login kembali.');
        }

        // 3. Gunakan DB Transaction & Try-Catch untuk mendeteksi kegagalan simpan
        DB::beginTransaction();
        try {
            $nama_gambar = null;
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $nama_gambar = time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('gambar_thread'), $nama_gambar);
            }

            // 4. Proses Insert
            Thread::create([
                'Id_Masyarakat' => $user->Id_Masyarakat, 
                'Isi_Thread'    => $request->isi,        
                'Gambar_Thread' => $nama_gambar,     
                'Tanggal'       => now()                  
            ]);

            DB::commit();
            
            // 5. Redirect ke Forum Diskusi
            return redirect()->route('masyarakat.thread.index')
                             ->with('status', 'Diskusi baru berhasil dibagikan!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Jika gagal, kembali ke form dengan pesan error database
            return back()->withInput()->with('error', 'Gagal memposting: ' . $e->getMessage());
        }
    }
}
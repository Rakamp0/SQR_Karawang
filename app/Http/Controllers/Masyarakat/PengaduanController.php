<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $aduans = Pengaduan::where('Id_Masyarakat', $user->Id_Masyarakat)
                    ->orderBy('Tanggal_Pengaduan', 'desc') 
                    ->get();
                    
        return view('masyarakat.pengaduan.index', compact('aduans'));
    }

    public function create()
    {
        return view('masyarakat.pengaduan.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'judul' => 'required|max:30',
            'deskripsi' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // PERBAIKAN: Gunakan guard 'web'
        $user = Auth::guard('web')->user();

        // 2. Gunakan Transaction untuk keamanan data
        DB::beginTransaction();
        try {
            $nama_file = null;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $nama_file = time() . "_" . $file->getClientOriginalName();
                $file->move(public_path('dokumentasi'), $nama_file);
            }

            // 3. Simpan data
            Pengaduan::create([
                'Id_Masyarakat'     => $user->Id_Masyarakat,
                'Judul_Pengaduan'   => $request->judul,
                'Deskripsi'         => $request->deskripsi, 
                'Tanggal_Pengaduan' => now(),
                'dokumentasi'       => $nama_file,        
                'Keterangan'        => 'Ditinjau',        
                'Id_Instansi'       => 1,                 
            ]);

            DB::commit();

            return redirect()->route('masyarakat.pengaduan.index')->with('status', 'Aduan berhasil dikirim!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }
}
<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengaduanController extends Controller
{
    // Halaman utama list pengaduan saya
    public function index()
    {
        // Memastikan yang akses hanya masyarakat (guard: web)
        $user = Auth::guard('web')->user();

        // Jika sesi habis, kembali ke login
        if (!$user) {
            return redirect()->route('login');
        }

        // Ambil data pengaduan milik masyarakat yang login
        $aduans = Pengaduan::where('Id_Masyarakat', $user->Id_Masyarakat)
            ->orderBy('Tanggal_Pengaduan', 'asc')
            ->get();

        return view('masyarakat.pengaduan.index', compact('aduans'));
    }

    // Halaman form buat aduan
    public function create()
    {
        return view('masyarakat.pengaduan.create');
    }

    // Proses simpan pengaduan
    public function store(Request $request)
    {
        // Cek kelengkapan input
        $request->validate([
            'judul' => 'required|max:50',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048' 
        ]);

        // Mengecek masyarakat yang sedang login
        $user = Auth::guard('web')->user();

        // Buat koordinat random
        $latMin = -6.400000;
        $latMax = -6.150000;
        $lngMin = 107.250000;
        $lngMax = 107.500000;
        $latitude = $latMin + mt_rand() / mt_getrandmax() * ($latMax - $latMin);
        $longitude = $lngMin + mt_rand() / mt_getrandmax() * ($lngMax - $lngMin);

        // Pakai transaction agar jika upload gagal, data tidak masuk database
        DB::beginTransaction(); // Menyimpan data sementara
        try {
            $nama_file = null;

            // Proses Upload Gambar (Cara Web Biasa)
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                // Kasih nama unik pake waktu biar gak bentrok
                $nama_file = time() . "_" . $file->getClientOriginalName();
                // Simpan ke folder public/dokumentasi
                $file->move(public_path('dokumentasi'), $nama_file);
            }

            // Simpan ke tabel Pengaduan
            Pengaduan::create([
                'Id_Masyarakat' => $user->Id_Masyarakat,
                'Judul_Pengaduan' => $request->judul,
                'Kategori' => $request->kategori,
                'Deskripsi' => $request->deskripsi,
                'Tanggal_Pengaduan' => now(),
                'dokumentasi' => $nama_file,
                'Keterangan' => 'Ditinjau', 
                'Id_Instansi' => 1, 
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);

            DB::commit(); // Simpan permanen
            return redirect()->route('masyarakat.pengaduan.index')->with('status', 'Aduan berhasil dikirim!');

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua jika terjadi error
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Tampilkan form feedback
    public function showFeedbackForm($id)
    {
        // Mencari aduan berdasarkan masyarakat yang sedang login
        $aduan = Pengaduan::where('Id_Masyarakat', Auth::id())->findOrFail($id);

        // Validasi feedback bisa diisi jika status sudah selesai
        if ($aduan->Keterangan != 'Selesai') {
            return back()->with('status', 'Aduan belum selesai.');
        }

        // validasi sudah pernah mengisi atau belum?
        $sudah_isi = DB::table('feedback')->where('Id_Pengaduan', $id)->exists();
        if ($sudah_isi) {
            return back()->with('status', 'Kamu sudah mengisi feedback untuk laporan ini.');
        }

        return view('masyarakat.pengaduan.feedback', compact('aduan'));
    }

    // Simpan feedback dan tambah point
    public function storeFeedback(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required',
            'efektivitas' => 'required',
            'kemudahan' => 'required',
            'reward' => 'required',
        ]);

        DB::beginTransaction(); // Menyimpan data sementara
        try {
            $user = Auth::user(); // Mengecek yang sedang login

            // Input data kedalam tabel feedback langsung denan ID feedback baru
            $id_feedback_baru = DB::table('feedback')->insertGetId([
                'Id_Masyarakat' => $user->Id_Masyarakat,
                'Id_Pengaduan' => $id,
                'Komentar' => $request->komentar,
                'Konfirmasi' => 'Selesai',
                'Efektivitas' => $request->efektivitas,
                'Kemudahan' => $request->kemudahan,
                'Reward' => $request->reward
            ]);

            // Menambah poin 
            DB::table('riwayat_poin')->insert([
                'Id_Masyarakat' => $user->Id_Masyarakat,
                'Id_Feedback' => $id_feedback_baru,
                'Jumlah_Poin' => 1,
                'Jenis_Transaksi' => 'Masuk',
                'Keterangan' => 'Reward Feedback Laporan #' . $id,
                'Tanggal_Transaksi' => now()
            ]);

            // Update poin di profil masyarakat
            DB::table('masyarakat')
                ->where('Id_Masyarakat', $user->Id_Masyarakat)
                ->increment('Poin', 1);

            DB::commit(); // Simpan data permanen kedalam database
            return redirect()->route('masyarakat.pengaduan.index')->with('status', 'Feedback terkirim! Poin bertambah +1.');

        // Jika terjadi error
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('status', 'Gagal menyimpan feedback: ' . $e->getMessage());
        }
    }
}
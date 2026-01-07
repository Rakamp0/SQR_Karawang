<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{

    // Menampilkan daftar pengaduan, tampilan dibedakan antara admin/petugas dengan instansi
    public function index()
    {
        $pengaduans = [];
        $listInstansi = [];

        // Cek login apakah sebagai instansi?
        if (Auth::guard('instansi')->check()) {

            // Ambil data user instansi yang sedang login
            $user_instansi = Auth::guard('instansi')->user();

            // Query data khusus untuk dinas tersebut
            // Hanya aduan milik dinas ini dan statusnya sudah divalidasi oleh admin/petugas
            $pengaduans = Pengaduan::with(['masyarakat', 'instansi'])
                ->where('Id_Instansi', $user_instansi->Id_Instansi)
                ->whereIn('Keterangan', ['Valid', 'Diproses', 'Selesai']) // Filter status tampilan
                ->orderBy('Tanggal_Pengaduan', 'asc')
                ->get();

        }
        // Cek login apakah sebagai admin/petugas?
        elseif (Auth::guard('petugas')->check()) {

            // Ambil data dari tabel pengaduan
            // Untuk admin/petugas tampilkan semua data
            // With untuk relasi tabel masyarakat dan instansi
            $pengaduans = Pengaduan::with(['masyarakat', 'instansi'])
                ->orderBy('Tanggal_Pengaduan', 'asc')
                ->get();

            // Data list instansi untuk dropdown saat validasi
            $listInstansi = Instansi::all();
        }

        // Tampilkan data ke view
        return view('admin.pengaduan.index', [
            'pengaduans' => $pengaduans,
            'listInstansi' => $listInstansi
        ]);
    }

    // Update status aduan
    public function updateStatus(Request $request, $id)
    {
        // Cari data pengaduan berdasarkan ID, jika tidak ada error 404
        $pengaduan = Pengaduan::findOrFail($id);

        // Ambil input status baru dari form
        $status_baru = $request->status;

        // Logika untuk admin/petugas. 
        // Cek apakah yang login itu admin/petugas?
        if (Auth::guard('petugas')->check()) {

            // Jika aduan valid, pilih instansi tujuan
            if ($status_baru == 'Valid') {

                // Validasi input, id_instansi harus ada di tabel instansi
                $request->validate([
                    'id_instansi' => 'required|exists:instansi,Id_Instansi'
                ]);

                // Update data
                $pengaduan->Keterangan = 'Valid';
                $pengaduan->Id_Instansi = $request->id_instansi; // Oper tugas ke dinas terkait
                $pengaduan->save();

                return back()->with('success', 'Laporan Valid! Tugas telah diserahkan ke Dinas terkait.');
            }

            // Jika aduan ditolak
            if ($status_baru == 'Ditolak') {
                $pengaduan->Keterangan = 'Ditolak';
                $pengaduan->save();

                return back()->with('success', 'Laporan telah ditolak.');
            }
        }

        // Logika untuk instansi
        // Cek apakah yang login instansi?
        elseif (Auth::guard('instansi')->check()) {

            // Mengambil data dari instansi yang sedang login
            $user_instansi = Auth::guard('instansi')->user();

            // Cek apakah aduan sesuai dengan instansi yang sudah ditujukan?
            if ($pengaduan->Id_Instansi != $user_instansi->Id_Instansi) {
                return back()->with('error', 'Akses Ditolak! Ini bukan laporan untuk dinas Anda.');
            }

            // Update status, hanya boleh 'Diproses' atau 'Selesai'
            if (in_array($status_baru, ['Diproses', 'Selesai'])) {
                $pengaduan->Keterangan = $status_baru;
                $pengaduan->save();

                return back()->with('success', 'Status laporan berhasil diperbarui!');
            }
        }

        // Respon lain
        return back()->with('error', 'Aksi tidak diizinkan atau status tidak valid.');
    }
}
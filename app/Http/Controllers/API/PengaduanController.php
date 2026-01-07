<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PengaduanController extends Controller
{
    // Mengambil daftar aduan saya
    public function index(Request $request)
    {
        // Ambil data user dari Token, yang sedang login
        $user = $request->user();

        // Cari aduan milik masyarakat yang sedang login
        $aduans = Pengaduan::where('Id_Masyarakat', $user->Id_Masyarakat)
            ->with('feedback')  
            ->orderBy('Tanggal_Pengaduan', 'desc') 
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'List Pengaduan berhasil diambil',
            'data' => $aduans
        ], 200);
    }

    // Buat aduan baru
    // Menerima Text + Foto (Base64) dari Flutter.
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'judul' => 'required|max:50',
            'isi_laporan' => 'required',
            'kategori' => 'required', 
            'latitude' => 'required',
            'longitude' => 'required',
            'foto' => 'required', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Mohon lengkapi semua data laporan.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();
            $nama_file = null;

            // Proses decode foto dari base64 ke file jpg
            if ($request->foto) {
                $image = $request->foto;

                // Cek apakah ada header data:image/jpeg;base64 ?
                if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {

                    // strpos($image, ',') -> Cari posisi tanda koma (,) ada di urutan ke berapa?
                    // + 1 -> Perintah untuk maju satu langkah
                    // substr($image, ...) -> Memotong teks mulai dari posisi setelah koma hingga ke belakang 
                    $image = substr($image, strpos($image, ',') + 1);
                    $type = strtolower($type[1]); 

                    // Cek tipe file 
                    if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                        return response()->json(['message' => 'Tipe file tidak didukung'], 400);
                    }

                    $image = str_replace(' ', '+', $image);
                    $image = base64_decode($image);
                } else {
                    $image = base64_decode($request->foto);
                }

                // Membuat nama unik untuk setiap file yang di upload
                $nama_file = time() . '_laporan.jpg';

                // Lokasi penyimpanan file
                $path = public_path('dokumentasi/' . $nama_file);

                // Menyimpan file
                File::put($path, $image);
            }

            // Menyimpan data ke database
            $pengaduan = Pengaduan::create([
                'Id_Masyarakat' => $user->Id_Masyarakat, // Otomatis dari Token

                // Kiri kolom database, kanan inputan dari flutter
                'Judul_Pengaduan' => $request->judul,
                'Deskripsi' => $request->isi_laporan,
                'Kategori' => $request->kategori,

                'Tanggal_Pengaduan' => now(), // Waktu server sekarang
                'dokumentasi' => $nama_file, // Cuma simpan nama filenya aja
                'Keterangan' => 'Ditinjau', // Status awal 
                'Id_Instansi' => 1, // Default ke Dinas Pusat 
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            // Aduan berhasil dikirim
            return response()->json([
                'success' => true,
                'message' => 'Laporan Berhasil Dikirim! Petugas akan segera meluncur.',
                'data' => $pengaduan
            ], 201);

        } catch (\Exception $e) {
            // Error handling
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim laporan: ' . $e->getMessage()
            ], 500);
        }
    }
}
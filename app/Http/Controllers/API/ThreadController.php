<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Import ini wajib biar bisa simpan file
use Illuminate\Support\Facades\Validator;

class ThreadController extends Controller
{
    // Mengambil daftar thread
    public function index(Request $request)
    {
        // Mengambil thread dari tabel Thread dengan data masyarakat(Pembuat thread)
        $threads = Thread::with('masyarakat')
            ->orderBy('Tanggal', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Thread berhasil diambil',
            'data' => $threads
        ], 200);
    }

    // Buat thread baru
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'isi' => 'required|min:5', // Wajib ada minimal 5 char
            'gambar' => 'nullable', // Gambar opsional
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();
            $nama_gambar = null;

            // Logika gambar 
            // Sama seperti di PengaduanController
            if ($request->gambar) {
                $image = $request->gambar;

                // Cek apakah ada header data:image/jpeg;base64 ?
                if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {

                    // strpos($image, ',') -> Cari posisi tanda koma (,) ada di urutan ke berapa?
                    // + 1 -> Perintah untuk maju satu langkah
                    // substr($image, ...) -> Memotong teks mulai dari posisi setelah koma hingga ke belakang
                    $image = substr($image, strpos($image, ',') + 1);
                    $type = strtolower($type[1]); 

                    // Cek tipe file
                    if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                        return response()->json(['message' => 'Format gambar tidak didukung'], 400);
                    }

                    $image = str_replace(' ', '+', $image);
                    $image = base64_decode($image);
                } else {
                    // Kalau raw base64
                    $image = base64_decode($request->gambar);
                }

                // Membuat nama unik untuk setiap file yang di upload
                $nama_gambar = time() . '_thread.jpg';
                $path = public_path('gambar_thread/' . $nama_gambar);

                // Menyimpan file
                File::put($path, $image);
            }
 
            // Simpan ke Database
            $thread = Thread::create([
                'Id_Masyarakat' => $user->Id_Masyarakat,
                'Isi_Thread' => $request->isi,
                'Gambar_Thread' => $nama_gambar, 
                'Tanggal' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thread berhasil diposting!',
                'data' => $thread
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback; 
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
  
    // Menyimpan feedback dan memberikan 1 poin kepada user
    public function store(Request $request)
    {
        // Cek kelengkapan data
        $validator = Validator::make($request->all(), [
            'id_pengaduan' => 'required|exists:pengaduan,Id_Pengaduan', // Cek apakah laporannya ada?
            'komentar'     => 'required|string',
            'efektivitas'  => 'required', 
            'kemudahan'    => 'required',
            'reward'       => 'required', 
        ]);

        // Jika tidak valid
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data feedback tidak valid/kurang lengkap.',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Proses penyimpanan data
        try {
          
            // Ambil data yang sedang login
            $user_pelapor = $request->user();

            // Simpan feedback kedalam database
            $data_feedback = Feedback::create([
                'Id_Masyarakat' => $user_pelapor->Id_Masyarakat,
                'Id_Pengaduan'  => $request->id_pengaduan,
                'Komentar'      => $request->komentar,
                'Konfirmasi'    => 'Selesai', 
                'Efektivitas'   => $request->efektivitas,
                'Kemudahan'     => $request->kemudahan,
                'Reward'        => $request->reward,
            ]);

            // Proses penambahan poin
            // Input poin ke database
            DB::table('riwayat_poin')->insert([
                'Id_Masyarakat'     => $user_pelapor->Id_Masyarakat,
                'Id_Feedback'       => $data_feedback->Id_Feedback,
                'Jumlah_Poin'       => 1, 
                'Jenis_Transaksi'   => 'Masuk',
                'Keterangan'        => 'Reward Feedback Aduan #' . $request->id_pengaduan,
                'Tanggal_Transaksi' => now(),
            ]);

            // Update poin
            DB::table('masyarakat')
                ->where('Id_Masyarakat', $user_pelapor->Id_Masyarakat)
                ->increment('Poin', 1);

            // Selesai
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih! Feedback tersimpan & Poin bertambah +1.',
                'data'    => $data_feedback
            ], 201);

        // Jika gagal
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan feedback: ' . $e->getMessage()
            ], 500);
        }
    }
}
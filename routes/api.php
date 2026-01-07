<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PengaduanController;
use App\Http\Controllers\Api\ThreadController;
use App\Http\Controllers\Api\FeedbackController;

// Route public, bisa diakses tanpa login

// Endpoint untuk cek koneksi 
// Jika diakses browser muncul JSON, berarti API hidup.
Route::get('/tes', function () {
    return response()->json(['message' => 'Halo Flutter, Laravel siap!']);
});

// Endpoint registrasi user baru
// Method post, karena mengirim data ke database.
Route::post('/register', [AuthController::class, 'register']);

// Endpoint login
// Method post, ggirim email dan password untuk mendapat token akses.
Route::post('/login', [AuthController::class, 'login']);

// Route protected, harus login/memiliki token
// 'auth:sanctum' mengecek token.
Route::middleware('auth:sanctum')->group(function () {

    // User dan Auth
    // Ambil data user yang sedang login saat ini
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Ambil profil user lengkap untuk menampilkan data
    Route::get('/me', [AuthController::class, 'me']);

    // Pengaduan
    // Ambil semua list pengaduan menggunakan method get
    Route::get('/pengaduan', [PengaduanController::class, 'index']);

    // Kirim laporan pengaduan baru, menggunakan method post untuk mengirim data aduan ke server
    Route::post('/pengaduan', [PengaduanController::class, 'store']);

    // Thread
    // Ambil daftar thread menggunakan method get
    Route::get('/thread', [ThreadController::class, 'index']);

    // Buat thread, menggunakan method post untuk posting\
    Route::post('/thread', [ThreadController::class, 'store']);

    // Feedback
    // Kirim feedback aplikasi
    Route::post('/feedback', [FeedbackController::class, 'store']);

});
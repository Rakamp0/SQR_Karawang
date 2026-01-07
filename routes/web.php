<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Controller admin/petugas dan instansi
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduan;
use App\Http\Controllers\Admin\ThreadController as AdminThread;

// Controller masyarakat
use App\Http\Controllers\Masyarakat\PengaduanController as MsyPengaduan;
use App\Http\Controllers\Masyarakat\ThreadController as MsyThread;


Route::redirect('/', '/login');

// Route admin/petugas dan instansi
// Middleware gabungan, petugas/admin dan instansi bisa masuk disini
Route::middleware(['auth:petugas,instansi'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard utama, memanggil dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Pengaduan
    Route::get('/pengaduan', [AdminPengaduan::class, 'index'])->name('pengaduan');
    // Route::patch -> update sebagian kecil data
    Route::patch('/pengaduan/{id}/status', [AdminPengaduan::class, 'updateStatus'])->name('pengaduan.update');

    // Manajemen Thread
    Route::middleware('auth:petugas')->group(function () {
        Route::get('/thread', [AdminThread::class, 'index'])->name('thread');
        Route::delete('/thread/{id}', [AdminThread::class, 'destroy'])->name('thread.delete');
    });
});

// Route masyarakat
Route::middleware(['auth:web'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Setting Profile User
    // Menampilkan data user
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Menyimpan sebagian perubahan data
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Hapus akun
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Grouping fitur masyarakat 
    Route::prefix('masyarakat')->name('masyarakat.')->group(function () {

        // CRUD Pengaduan
        // Melihat aduan yang sudah dibuat
        Route::get('/pengaduan', [MsyPengaduan::class, 'index'])->name('pengaduan.index');
        // Menampilkan form pengaduan
        Route::get('/pengaduan/create', [MsyPengaduan::class, 'create'])->name('pengaduan.create');
        // Mengirim data ke server
        Route::post('/pengaduan', [MsyPengaduan::class, 'store'])->name('pengaduan.store');

        // Feedback user setelah laporan selesai
        // Menampilkan form feedback berdasarkan id pengaduan
        Route::get('/pengaduan/{id}/feedback', [MsyPengaduan::class, 'showFeedbackForm'])->name('feedback.create');
        // Mengirim data ke server 
        Route::post('/pengaduan/{id}/feedback', [MsyPengaduan::class, 'storeFeedback'])->name('feedback.store');

        // Thread
        // Menampilkan semua thread
        Route::get('/thread', [MsyThread::class, 'index'])->name('thread.index');
        // Menampilkan form thread
        Route::get('/thread/create', [MsyThread::class, 'create'])->name('thread.create');
        // Mengirim data ke server
        Route::post('/thread', [MsyThread::class, 'store'])->name('thread.store');
        // Menampilkan rincian thread berdasarkan id thread
        Route::get('/thread/{id}', [MsyThread::class, 'show'])->name('thread.show');
    });
});

// Route bantuan
// img-proxy bypass cors dan localhost untuk flutter agar gambar tetap bisa di load
Route::get('/img-proxy/{filename}', function ($filename) {
    // mencari file fisik dari gambar 
    $path = public_path('dokumentasi/' . $filename);

    // Jika filenya tidak ada, beri pesan 404
    if (!file_exists($path))
        abort(404);

    // Mengirim binary dari file
    return response()->file($path, [
        // Digunakan untuk mengatur akses CORS (Cross-Origin Resource Sharing), 
        // memberi tahu browser bahwa resource dari server (open source)
        'Access-Control-Allow-Origin' => '*',
        // Memberi label otomatis untuk file gambar
        'Content-Type' => mime_content_type($path),
    ]);
});

// img-proxy bypass cors dan localhost untuk flutter agar gambar tetap bisa di load
Route::get('/thread-img-proxy/{filename}', function ($filename) {
    // mencari file fisik dari gambar 
    $path = public_path('gambar_thread/' . $filename);

    // Jika filenya tidak ada, beri pesan 404
    if (!file_exists($path))
        abort(404);

    // Mengirim binary dari file
    return response()->file($path, [
        // Digunakan untuk mengatur akses CORS (Cross-Origin Resource Sharing), 
        // memberi tahu browser bahwa resource dari server (open source)
        'Access-Control-Allow-Origin' => '*',
        // Memberi label otomatis untuk file gambar
        'Content-Type' => mime_content_type($path),
    ]);
});

// memasukkan file auth.php ke file PHP yang sedang dijalankan, dan wajib ada.
require __DIR__ . '/auth.php';
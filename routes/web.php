<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduan;
use App\Http\Controllers\Admin\ThreadController as AdminThread;
use App\Http\Controllers\Masyarakat\PengaduanController as MsyPengaduan;
use App\Http\Controllers\Masyarakat\ThreadController as MsyThread;

Route::get('/', function () {
    return view('welcome');
});

// --- BAGIAN ADMIN (PETUGAS) ---
// Guard: petugas
Route::middleware(['auth:petugas', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengaduan', [AdminPengaduan::class, 'index'])->name('pengaduan');
    Route::patch('/pengaduan/{id}/status', [AdminPengaduan::class, 'updateStatus'])->name('pengaduan.update');
    Route::get('/thread', [AdminThread::class, 'index'])->name('thread');
    Route::delete('/thread/{id}', [AdminThread::class, 'destroy'])->name('thread.delete');
});

// --- BAGIAN MASYARAKAT ---
// PERUBAHAN: Gunakan 'auth:web' karena guard 'web' sudah diarahkan ke provider masyarakat di auth.php
Route::middleware(['auth:web', 'role:masyarakat'])->group(function () {
    
    // Dashboard Masyarakat
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Menu Fitur Masyarakat dengan prefix 'masyarakat'
    Route::prefix('masyarakat')->name('masyarakat.')->group(function () {
        Route::get('/pengaduan', [MsyPengaduan::class, 'index'])->name('pengaduan.index');
        Route::get('/pengaduan/create', [MsyPengaduan::class, 'create'])->name('pengaduan.create');
        Route::post('/pengaduan', [MsyPengaduan::class, 'store'])->name('pengaduan.store');

        Route::get('/thread', [MsyThread::class, 'index'])->name('thread.index');
        Route::get('/thread/create', [MsyThread::class, 'create'])->name('thread.create');
        Route::post('/thread', [MsyThread::class, 'store'])->name('thread.store');
        Route::get('/thread/{id}', [MsyThread::class, 'show'])->name('thread.show');
    });
});

require __DIR__.'/auth.php';
<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// Route autentikasi untuk admin

// Guest
// Middleware 'guest', hanya yang belum login yang bisa mengakses 
Route::middleware('guest')->group(function () {

    // Registrasi
    // Menampilkan form registrasi
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // Proses simpan data user baru
    Route::post('register', [RegisteredUserController::class, 'store']);


    // Login
    // Menampilkan form login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Proses cek email dan password 
    Route::post('login', [AuthenticatedSessionController::class, 'store']);


    // Lupa password
    // Form link reset email (input email)
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    // Kirim link reset ke email user
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Form ganti password baru 
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    // Proses simpan password baru ke database
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Auth
// Middleware 'auth', hanya user yang sudah login yang bisa akses
Route::middleware('auth')->group(function () {

    // Verifikasi email
    // Tampilan "Tolong verifikasi email anda"
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    // Link konfirmasi yang diklik dari email 
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1']) // Throttle: membatasi klik agar tidak spam
        ->name('verification.verify');

    // Tombol "Kirim Ulang Email Verifikasi"
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');


    // Konfirmasi password
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);


    // Update password, untuk diganti manual oleh user di profil
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');


    // Logout, hapus sesi
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
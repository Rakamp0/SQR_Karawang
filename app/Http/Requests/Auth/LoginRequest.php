<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authenticate(): void
    {
    $this->ensureIsNotRateLimited();

    // Tentukan kredensial berdasarkan pilihan role di dropdown
    if ($this->role === 'admin') {
        // Mengacu pada struktur tabel petugas
        $credentials = [
            'Email_Petugas' => $this->Email_Masyarakat, // Input email dari form
            'password' => $this->Password_Msy,          // Input password dari form
        ];

        // Gunakan guard 'petugas' jika Anda sudah mengaturnya di config/auth.php
        if (! Auth::guard('petugas')->attempt($credentials, $this->boolean('remember'))) {
            $this->sendFailedLoginResponse();
        }
    } else {
        // Default untuk Masyarakat
        $credentials = [
            'Email_Masyarakat' => $this->Email_Masyarakat,
            'password' => $this->Password_Msy,
        ];

        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            $this->sendFailedLoginResponse();
        }
    }

    RateLimiter::clear($this->throttleKey());
    }

/**
 * Pindahkan logika error ke fungsi terpisah agar kode lebih bersih
 */
    protected function sendFailedLoginResponse()
    {
    RateLimiter::hit($this->throttleKey());

    throw ValidationException::withMessages([
        'Email_Masyarakat' => "Email atau Password salah untuk role " . $this->role,
    ]);
    }
}
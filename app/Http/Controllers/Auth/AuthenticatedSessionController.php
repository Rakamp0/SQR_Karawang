<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    // Tampil halaman login
    public function create(): View
    {
        return view('auth.login');
    }

    // Proses Login
    public function store(LoginRequest $request): RedirectResponse
    {
        // Mengeluarkan sesi yang tersangkut
        Auth::guard('web')->logout();
        Auth::guard('petugas')->logout();
        Auth::guard('instansi')->logout();

        // Cek login sesuai role yang dipilih
        // Pilih admin/petugas
        if ($request->role === 'admin') {
            // Cek tabel petugas 
            $cek_login = Auth::guard('petugas')->attempt([
                'Email_Petugas' => $request->Email_Masyarakat, 
                'password' => $request->Password_Msy, 
            ]);

            if ($cek_login) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }
        }

        // Pilih instansi
        elseif ($request->role === 'instansi') {
            // Cek tabel instansi
            $cek_login = Auth::guard('instansi')->attempt([
                'Email_Instansi' => $request->Email_Masyarakat,
                'password' => $request->Password_Msy,
            ]);

            if ($cek_login) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }
        }

        // Pilih sebagai masyarakat
        else {
            // Cek tabel masyarakat
            $cek_login = Auth::guard('web')->attempt([
                'Email_Masyarakat' => $request->Email_Masyarakat,
                'password' => $request->Password_Msy,
            ]);

            if ($cek_login) {
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            }
        }

        // Jika email/password salah
        return back()->withErrors([
            'Email_Masyarakat' => 'Login gagal, periksa email atau password.',
        ])->withInput($request->only('Email_Masyarakat', 'role'));
    }

    // Proses Logout
    public function destroy(Request $request): RedirectResponse
    {
        // Logout semuanya biar aman
        Auth::guard('web')->logout();
        Auth::guard('petugas')->logout();
        Auth::guard('instansi')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
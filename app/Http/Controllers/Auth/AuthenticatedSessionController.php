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
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $login = $request->Email_Masyarakat;
        $password = $request->Password_Msy;
        $role = $request->role;

        // 1. Logika Login Admin (Guard Petugas)
        if ($role === 'admin') {
            $credentials = [
                'Email_Petugas' => $login, 
                'password' => $password // Tetap gunakan key 'password'
            ];

            if (Auth::guard('petugas')->attempt($credentials)) {
                $request->session()->regenerate();
                // Menggunakan route name lebih aman daripada path manual
                return redirect()->intended(route('admin.dashboard'));
            }
        } 
        // 2. Logika Login Masyarakat (Guard Web)
        else {
            $credentials = [
                'Email_Masyarakat' => $login, 
                'password' => $password
            ];

            if (Auth::guard('web')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended(route('dashboard'));
            }
        }

        // 3. Jika gagal (Email/Password tidak cocok di kedua guard)
        return back()->withErrors([
            'Email_Masyarakat' => 'Email atau Password salah untuk akses ' . ($role ?? 'pengguna'),
        ])->withInput($request->only('Email_Masyarakat', 'role'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        // Logout dari semua kemungkinan guard yang aktif
        Auth::guard('petugas')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
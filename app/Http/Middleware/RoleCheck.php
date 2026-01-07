<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    // Menangani permintaan masuk
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek akses admin/petugas dan instansi
        // admin/petugas menggunakan dashboard yang sama
        if ($role === 'admin') {
            if (Auth::guard('petugas')->check() || Auth::guard('instansi')->check()) {
                return $next($request);
            }
        }

        // Cek akses masyarakat
        if ($role === 'masyarakat') {
            if (Auth::guard('web')->check()) {
                return $next($request); 
            }
        }

        // Jika belum login sama sekali
        if (
            !Auth::guard('petugas')->check() &&
            !Auth::guard('instansi')->check() &&
            !Auth::guard('web')->check()
        ) {
            return redirect()->route('login')->with('error', 'Eits, login dulu ya!');
        }

        // Sudah login tapi coba buka halaman instansi
        return abort(403, 'Maaf, Anda tidak punya akses ke halaman ini.');
    }
}
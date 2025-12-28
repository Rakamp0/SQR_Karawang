<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Periksa akses Admin menggunakan guard petugas
        if ($role === 'admin') {
            if (Auth::guard('petugas')->check()) {
                return $next($request);
            }
        }

        // 2. Periksa akses Masyarakat menggunakan guard web (masyarakat)
        if ($role === 'masyarakat') {
            if (Auth::guard('web')->check()) {
                return $next($request);
            }
        }

        // 3. JIKA GAGAL: Bedakan antara "Belum Login" dan "Salah Role"
        
        // Jika belum login sama sekali, baru lempar ke login
        if (!Auth::guard('petugas')->check() && !Auth::guard('web')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Jika sudah login tapi mencoba akses yang bukan haknya (misal: Masyarakat mau buka menu Admin)
        // Jangan lempar ke login (biar tidak looping), tapi lempar ke dashboard masing-masing atau abort 403
        return abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
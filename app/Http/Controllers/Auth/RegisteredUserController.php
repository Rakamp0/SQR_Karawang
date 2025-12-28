<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi sesuai dengan nama input di View terbaru
        $request->validate([
            'Nama_Masyarakat' => ['required', 'string', 'max:60'],
            'Username_Msy' => ['required', 'string', 'max:30', 'unique:masyarakat,Username_Msy'],
            'NIK_Masyarakat' => ['required', 'numeric'],
            'Alamat_Masyarakat' => ['required', 'string', 'max:200'],
            'Email_Masyarakat' => ['required', 'string', 'email', 'max:30', 'unique:masyarakat,Email_Masyarakat'],
            'Password_Msy' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Simpan ke tabel 'masyarakat' menggunakan Model User (yang sudah dihubungkan ke tabel masyarakat)
        $user = User::create([
            'Nama_Masyarakat' => $request->Nama_Masyarakat,
            'Username_Msy' => $request->Username_Msy,
            'NIK_Masyarakat' => $request->NIK_Masyarakat,
            'Alamat_Masyarakat' => $request->Alamat_Masyarakat,
            'Email_Masyarakat' => $request->Email_Masyarakat,
            'Password_Msy' => Hash::make($request->Password_Msy),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirect ke dashboard masyarakat
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
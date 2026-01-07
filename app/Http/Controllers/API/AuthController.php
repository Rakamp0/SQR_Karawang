<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Registrasi masyarakat dari mobile (flutter)
    // Input JSON -> validasi -> simpan ke database -> sukses
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'Nama_Masyarakat' => ['required', 'string', 'max:60'],
            'Username_Msy' => ['required', 'string', 'max:30', 'unique:masyarakat,Username_Msy'], // Username tidak boleh sama
            'NIK_Masyarakat' => ['required', 'numeric'], // NIK wajib angka
            'Alamat_Masyarakat' => ['required', 'string', 'max:200'],
            'Email_Masyarakat' => ['required', 'string', 'email', 'max:30', 'unique:masyarakat,Email_Masyarakat'], // Email tidak boleh sama
            'Password_Msy' => ['required', 'string', 'min:6'],
        ]);

        // Cek hasil validasi
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal. Mohon periksa kembali data Anda.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Proses penyimpanan data, (membuat user)
        try {
            // Menyimpan data kedalam tabel users
            $user_baru = User::create([
                'Nama_Masyarakat' => $request->Nama_Masyarakat,
                'Username_Msy' => $request->Username_Msy,
                'NIK_Masyarakat' => $request->NIK_Masyarakat,
                'Alamat_Masyarakat' => $request->Alamat_Masyarakat,
                'Email_Masyarakat' => $request->Email_Masyarakat,
                'Password_Msy' => Hash::make($request->Password_Msy),
            ]);

            // Respon sukses
            return response()->json([
                'success' => true,
                'message' => 'Registrasi Berhasil! Silakan Login.',
                'data' => $user_baru
            ], 201); 

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    // Login masyarakat
    // Cek email, password dan buat token
    public function login(Request $request)
    {
        $user = null;

        // Validasi email dan password
        $validator = Validator::make($request->all(), [
            'Email_Masyarakat' => 'required|email',
            'Password_Msy' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password tidak boleh kosong.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cari user di database
        $user = User::where('Email_Masyarakat', $request->Email_Masyarakat)->first();

        // Validasi password
        if (!$user || !Hash::check($request->Password_Msy, $user->Password_Msy)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password salah!',
            ], 401); 
        }

        // Pembuatan token untuk request data lain tanpa login ulang
        $token = $user->createToken('auth_token_mobile')->plainTextToken;

        // Kirim respon ke flutter
        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil!',
            'user' => $user,  // Data profil user
            'token' => $token, // Token rahasia
        ], 200);
    }

    // Mengambil data user yang sedang login
    public function me(Request $request)
    {
        // Fungsi $request->user() otomatis mengambil data user dari Token yang dikirim
        return response()->json([
            'success' => true,
            'message' => 'Data User Berhasil Diambil',
            'user' => $request->user(),
        ], 200);
    }
}
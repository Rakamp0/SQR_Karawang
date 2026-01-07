<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed instansi
        DB::table('instansi')->insert([
            ['Nama_Instansi' => 'Dinas Lingkungan Hidup', 'Jenis_Instansi' => 'Pemda', 'Alamat_Instansi' => 'Jl. A Yani', 'Email_Instansi' => 'dlhk@karawang.go.id', 'Password_Instansi' => Hash::make('password')],
            ['Nama_Instansi' => 'Dinas PUPR', 'Jenis_Instansi' => 'Pemda', 'Alamat_Instansi' => 'Jl. Surotokunto', 'Email_Instansi' => 'pupr@karawang.go.id', 'Password_Instansi' => Hash::make('password')],
            ['Nama_Instansi' => 'Satpol PP', 'Jenis_Instansi' => 'Pemda', 'Alamat_Instansi' => 'Komplek Pemda', 'Email_Instansi' => 'satpol@karawang.go.id', 'Password_Instansi' => Hash::make('password')],
            ['Nama_Instansi' => 'Dinas Perhubungan', 'Jenis_Instansi' => 'Pemda', 'Alamat_Instansi' => 'Jl. Tuparev', 'Email_Instansi' => 'dishub@karawang.go.id', 'Password_Instansi' => Hash::make('password')],
            ['Nama_Instansi' => 'PLN Karawang', 'Jenis_Instansi' => 'BUMN', 'Alamat_Instansi' => 'Jl. Kertabumi', 'Email_Instansi' => 'pln@karawang.co.id', 'Password_Instansi' => Hash::make('password')],
        ]);

        // Seed petugas/admin
        DB::table('petugas')->insert([
            [
                'Nama_Petugas' => 'Admin 1',
                'Username_Ptgs' => 'admin 1', 
                'NIK_Petugas' => 1234567890123456,
                'Alamat_Petugas' => 'Kantor Pusat SQR',
                'Email_Petugas' => 'admin@sqr.com',
                'Password_Petugas' => Hash::make('password'), 
            ],
        ]);

        // Seed masyarakat
        DB::table('masyarakat')->insert([
            [
                'Nama_Masyarakat' => 'Rudi Tabuti',
                'Username_Msy' => 'rudi',
                'NIK_Masyarakat' => 3215020202920002,
                'Alamat_Masyarakat' => 'Cikampek',
                'Email_Masyarakat' => 'rudi@gmail.com',
                'Password_Msy' => Hash::make('password'),
                'foto_profile' => null,
                'Poin' => 0,
            ]
        ]);

    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('petugas')->insert([
            'Nama_Petugas'     => 'Admin SQR',
            'Username_Ptgs'   => 'admin_pusat',
            'NIK_Petugas'      => 1234567890123456, //
            'Alamat_Petugas'   => 'Kantor Pusat SQR Karawang',
            'Email_Petugas'    => 'admin@sqr.com',
            'Password_Petugas' => Hash::make('password123'), // Password untuk login
        ]);
    }
}
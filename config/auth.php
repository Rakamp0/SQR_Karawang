<?php

return [

    // Default, menentukan user default
    'defaults' => [
        // Default -> 'web', user login defaultnya sebagai masyarakat
        'guard' => 'web',

        // Default lupa password
        'passwords' => 'users',
    ],

    // Autentikasi guards
    'guards' => [
        // Guard web (default, masyarakat)
        'web' => [
            'driver' => 'session',      // Login disimpan menggunakan session browser (cookie)
            'provider' => 'masyarakat', // Guard 'web' mengambil data dari 'masyarakat'.
        ],

        // Guard petugas
        'petugas' => [
            'driver' => 'session',      // Login disimpan menggunakan session
            'provider' => 'petugas',    // Guard 'petugas' mengambil data dari 'petugas'
        ],

        // Guard instansi
        'instansi' => [
            'driver' => 'session',
            'provider' => 'instansi',
        ],
    ],

    // Sumber data user, memberitahu laravel tabel/model yang digunakan untuk mengambil data user
    'providers' => [
        // Masyarakat
        'masyarakat' => [
            'driver' => 'eloquent',             // Pake sistem Model Laravel (Eloquent).
            'model' => App\Models\Masyarakat::class, // Modelnya di file Masyarakat.php.
        ],

        // Sumber Data Petugas
        'petugas' => [
            'driver' => 'eloquent',
            'model' => App\Models\Petugas::class, // Modelnya di file Petugas.php.
        ],

        // Sumber Data Instansi
        'instansi' => [
            'driver' => 'eloquent',
            'model' => App\Models\Instansi::class, // Modelnya di file Instansi.php.
        ],

        // Data users bawaan laravel yang diarahkan masyarakat
        // *fitur reset password bawaan Laravel mengambil dari masyarakat.
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Masyarakat::class,
        ],
    ],

    // Lupa password
    'passwords' => [
        'users' => [
            'provider' => 'masyarakat', // Jika lupa password, cek email di tabel masyarakat
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'), // Nama tabel token di database.
            'expire' => 60,   // Token reset password expired dalam 60 menit.
            'throttle' => 60, // Jeda waktu sebelum boleh minta token lagi (detik).
        ],
    ],

    // Batas waktu konfirmasi password 
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
<?php

return [

    'defaults' => [
        // WAJIB: Gunakan 'web' sebagai default. 
        // Karena 'web' di bawah sudah diarahkan ke provider 'masyarakat'.
        'guard' => 'web', 
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'masyarakat', 
        ],

        'petugas' => [
            'driver' => 'session',
            'provider' => 'petugas', 
        ],

        // Hapus atau abaikan guard 'masyarakat' yang duplikat agar tidak membingungkan sistem
        'instansi' => [
            'driver' => 'session',
            'provider' => 'instansi',
        ],
    ],

    'providers' => [
        'masyarakat' => [
            'driver' => 'eloquent',
            'model' => App\Models\Masyarakat::class, 
        ],

        'petugas' => [
            'driver' => 'eloquent',
            'model' => App\Models\Petugas::class,
        ],

        'instansi' => [
            'driver' => 'eloquent',
            'model' => App\Models\Instansi::class,
        ],

        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Masyarakat::class, 
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'masyarakat',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
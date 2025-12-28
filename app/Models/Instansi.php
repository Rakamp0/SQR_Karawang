<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Instansi extends Authenticatable
{
    use Notifiable;

    protected $table = 'instansi';
    protected $primaryKey = 'Id_Instansi';

    // Sesuai kolom di tabel instansi
    protected $fillable = [
        'Nama_Instansi',
        'Password_Instansi',
        'Email_Instansi',
        'Alamat_Instansi',
        'No_Telepon_Ins'
    ];

    public $timestamps = false;

    // Memberitahu Laravel kolom password yang benar
    public function getAuthPassword()
    {
        return $this->Password_Ins;
    }
}

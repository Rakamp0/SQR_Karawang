<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Instansi extends Authenticatable
{
    use Notifiable;
    protected $table = 'instansi';
    protected $primaryKey = 'Id_Instansi';  
    public $timestamps = false;
    protected $fillable = [
        'Nama_Instansi',
        'Password_Instansi',
        'Email_Instansi',
        'Alamat_Instansi',
        'No_Telepon_Ins'
    ];

    public function getAuthPassword()
    {
        return $this->Password_Instansi;
    }
}
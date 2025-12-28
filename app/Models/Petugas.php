<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Petugas extends Authenticatable
{
    protected $table = 'petugas'; 
    protected $primaryKey = 'Id_Petugas'; 
    
    protected $fillable = [
        'Nama_Petugas', 
        'Username_Ptgs', 
        'NIK_Petugas', 
        'Alamat_Petugas', 
        'Email_Petugas', 
        'Password_Petugas' 
    ];

    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->Password_Petugas; 
    }
}
<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens; // Untuk API login
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Masyarakat extends Authenticatable
{
    use HasApiTokens, Notifiable; // Generate token untuk mobile
    protected $table = 'masyarakat'; 
    protected $primaryKey = 'Id_Masyarakat'; 
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Nama_Masyarakat',
        'Username_Msy', 
        'NIK_Masyarakat',
        'Alamat_Masyarakat',
        'Email_Masyarakat',
        'Password_Msy',
        'poin',
    ];

    // Kolom ini jangan pernah dikirim pas respon API (Rahasia)
    protected $hidden = [
        'Password_Msy',
    ];
    
    public function getAuthPassword()
    {
        return $this->Password_Msy;
    }
}
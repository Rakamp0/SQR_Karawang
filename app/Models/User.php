<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    // HasApiTokens untuk token mobile
    use HasApiTokens, HasFactory, Notifiable;

    // Arahkan model User default ini ke tabel masyarakat
    protected $table = 'masyarakat';
    protected $primaryKey = 'Id_Masyarakat';
    public $timestamps = false;

    protected $fillable = [
        'Nama_Masyarakat',
        'Username_Msy',
        'NIK_Masyarakat',
        'Alamat_Masyarakat',
        'Email_Masyarakat',
        'Password_Msy',
    ];

    // Sembunyikan data sensitif saat return JSON (API)
    protected $hidden = [
        'Password_Msy',
        'remember_token',
    ];

    public function getEmailAttribute()
    {
        return $this->Email_Masyarakat;
    }

    public function getAuthPassword()
    {
        return $this->Password_Msy;
    }
}
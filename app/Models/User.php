<?php

namespace App\Models;

// Hapus atau beri komentar pada baris Sanctum di bawah ini
// use Laravel\Sanctum\HasApiTokens; 
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable; // Hanya gunakan Notifiable

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

    protected $hidden = [
        'Password_Msy',
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

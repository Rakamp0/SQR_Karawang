<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';
    protected $primaryKey = 'Id_Pengaduan'; 
    public $timestamps = false; 

    protected $fillable = [
        'Id_Petugas', 'Id_Instansi', 'Id_Masyarakat', 
        'Deskripsi', 'Keterangan', 'Judul_Pengaduan', 
        'Tanggal_Pengaduan', 'latitude', 'longitude', 'dokumentasi'
    ];
    
    // Relasi ke User/Masyarakat
    public function masyarakat()
    {
        // Pastikan nama model User Anda benar (biasanya User atau M_Masyarakat)
        return $this->belongsTo(User::class, 'Id_Masyarakat', 'Id_Masyarakat');
    }
}
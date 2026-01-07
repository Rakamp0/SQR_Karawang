<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;
    protected $table = 'pengaduan';
    protected $primaryKey = 'Id_Pengaduan';
    public $timestamps = false; 
    protected $fillable = [
        'Id_Masyarakat',
        'Id_Petugas',
        'Id_Instansi',
        'Judul_Pengaduan',
        'Kategori',
        'Deskripsi',
        'Tanggal_Pengaduan',
        'dokumentasi',
        'Keterangan',
        'latitude',
        'longitude'
    ];

    // Rekasi ke masyarakat, 1 pengaduan 1 masyarakat
    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class, 'Id_Masyarakat', 'Id_Masyarakat');
    }

    // Relasi ke instandi, 1 pengaduan ditujukan ke 1 instansi
    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'Id_Instansi', 'Id_Instansi');
    }

    // Relasi ke petugas, 1 pengaduan ditangan oleh 1 petugas
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'Id_Petugas', 'Id_Petugas');
    }

    // Relasi ke feedback, 1 pengaduan memiliki 1 feedback
    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'Id_Pengaduan', 'Id_Pengaduan');
    }
}
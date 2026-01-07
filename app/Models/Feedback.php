<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedback';
    protected $primaryKey = 'Id_Feedback';
    public $timestamps = false;

    // Kolom database yang diisi
    protected $fillable = [
        'Id_Masyarakat',
        'Id_Pengaduan',
        'Komentar',
        'Konfirmasi',
        'Efektivitas',
        'Kemudahan',
        'Reward'
    ];

    /**
     * Relasi ke tabel Masyarakat
     * Satu feedback ditulis oleh satu masyarakat
     */
    // Relasi ke tabel masyarakat 1 feedback oleh 1 masyarakat
    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class, 'Id_Masyarakat', 'Id_Masyarakat');
    }

    // Relasi ke tabel pengaduan, 1 feedback merujuk ke satu pengaduan
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'Id_Pengaduan', 'Id_Pengaduan');
    }
}
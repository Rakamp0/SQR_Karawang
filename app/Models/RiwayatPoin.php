<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPoin extends Model
{
    use HasFactory;
    protected $table = 'riwayat_poin';
    protected $primaryKey = 'Id_Poin';
    public $timestamps = false;

    protected $fillable = [
        'Id_Masyarakat',
        'Id_Feedback',  
        'Jumlah_Poin',
        'Jenis_Transaksi', 
        'Keterangan',
        'Tanggal_Transaksi'
    ];
    
    // Poin milik masyarakat
    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class, 'Id_Masyarakat', 'Id_Masyarakat');
    }

    // Poin hasil dari feedback yang mana?
    public function feedback()
    {
        return $this->belongsTo(Feedback::class, 'Id_Feedback', 'Id_Feedback');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;
    protected $table = 'thread';
    protected $primaryKey = 'Id_Thread';
    public $timestamps = false;

    protected $fillable = [
        'Id_Masyarakat',
        'Isi_Thread',
        'Gambar_Thread',
        'Tanggal'
    ];

    // Relasi mengarah ke masyarakat
    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class, 'Id_Masyarakat', 'Id_Masyarakat');
    }
}
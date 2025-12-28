<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    protected $table = 'thread';
    protected $primaryKey = 'Id_Thread';

    protected $fillable = [
        'Id_Masyarakat', 
        'Isi_Thread', 
        'Gambar_Thread', 
        'Tanggal'
    ];

    public $timestamps = false;

    public function masyarakat()
    {
        return $this->belongsTo(User::class, 'Id_Masyarakat', 'Id_Masyarakat');
    }
}
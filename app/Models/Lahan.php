<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // ID pemilik lahan
        'nama_lahan',
        'nama_petani', // Tambahkan kolom nama_petani
        'luas_lahan',
        'jumlah_produksi',
        'foto_lahan',
        'no_wa',
        'latitude',
        'longitude',
    ];

    // Relasi ke tabel user (pemilik lahan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

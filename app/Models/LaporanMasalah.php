<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMasalah extends Model
{
    use HasFactory;

    /**
     * Secara eksplisit menentukan nama tabel yang digunakan oleh model ini.
     * @var string
     */
    protected $table = 'laporan_masalah'; // <-- TAMBAHKAN BARIS INI

    protected $fillable = [
        'user_id',
        'judul_laporan',
        'deskripsi_masalah',
        'kategori_masalah',
        'foto_masalah',
        'status',
    ];

    /**
     * Relasi ke User (pemilik laporan)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

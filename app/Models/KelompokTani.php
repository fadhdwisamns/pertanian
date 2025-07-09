<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class KelompokTani extends Model
{
    use HasFactory;

         protected $fillable = [
        'kecamatan', 'desa', 'nama_kelompok', 'alamat_sekretariat',
        'tahun_berdiri', 'komoditas_unggulan', 'ketua_kelompok',
        'kelas_kemampuan', 'sub_sektor',
        'latitude', 'longitude', 'foto_lokasi'
     ];

    public function users()
    {
        return $this->belongsToMany(
            User::class,              // Model tujuan
            'user_kelompok_tani',     // Nama tabel pivot
            'kelompok_tani_id',     // Foreign key di pivot untuk model ini (KelompokTani)
            'user_id'                 // Foreign key di pivot untuk model tujuan (User)
        );
    }
    public function getFotoUrlAttribute()
    {
        if ($this->foto_lokasi) {
            // Fungsi ini akan mengubah path yang tersimpan (misal: 'foto_kelompok_tani/namafile.jpg')
            // menjadi URL yang bisa diakses publik (misal: 'http://domain.com/storage/foto_kelompok_tani/namafile.jpg')
            return Storage::url($this->foto_lokasi);
        }

        // Kembalikan null atau path ke gambar default jika tidak ada foto
        return null;
    }
}

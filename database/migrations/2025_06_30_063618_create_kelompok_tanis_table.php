<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kelompok_tanis', function (Blueprint $table) {
                $table->id();
                $table->string('kecamatan');
                $table->string('desa');
                $table->string('nama_kelompok');
                $table->text('alamat_sekretariat');
                $table->year('tahun_berdiri');
                $table->string('komoditas_unggulan');
                $table->string('ketua_kelompok');
                $table->string('kelas_kemampuan')->default('Pemula'); // Pemula, Lanjut, Madya, Utama
                $table->string('sub_sektor'); // Tanaman Pangan, Perkebunan, Peternakan, dll.
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok_tanis');
    }
};

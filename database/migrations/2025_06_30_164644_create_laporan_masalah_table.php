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
        Schema::create('laporan_masalah', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID Petani yang melapor
        $table->string('judul_laporan');
        $table->text('deskripsi_masalah');
        $table->string('kategori_masalah'); // Contoh: Hama, Penyakit, Pupuk, Air
        $table->string('foto_masalah')->nullable();
        $table->string('status')->default('Dikirim'); // Contoh: Dikirim, Diproses, Selesai
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_masalah');
    }
};

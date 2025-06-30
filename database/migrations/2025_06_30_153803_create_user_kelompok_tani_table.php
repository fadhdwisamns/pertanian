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
        Schema::create('user_kelompok_tani', function (Blueprint $table) {
            $table->id(); // Kolom ID utama
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key ke tabel users
            $table->foreignId('kelompok_tani_id')->constrained()->onDelete('cascade'); // Foreign key ke tabel kelompok_tani (sesuaikan jika nama tabel Anda berbeda)
            $table->timestamps(); // Kolom created_at dan updated_at (opsional, tapi disarankan)

            // Menambahkan indeks unik untuk memastikan kombinasi user_id dan kelompok_tani_id adalah unik
            $table->unique(['user_id', 'kelompok_tani_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_kelompok_tani');
    }
};
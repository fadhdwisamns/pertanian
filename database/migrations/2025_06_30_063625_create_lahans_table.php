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
        Schema::create('lahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke pemilik (petani)
            $table->string('nama_lahan');
            $table->decimal('luas_lahan', 10, 2); // Luas dalam hektar/meter persegi
            $table->string('jumlah_produksi'); // Misal: "5 Ton / Musim"
            $table->string('foto_lahan')->nullable(); // Path ke foto lahan
            $table->string('no_wa'); // Nomor WhatsApp petani
            $table->decimal('latitude', 10, 8); // Koordinat untuk peta
            $table->decimal('longitude', 11, 8); // Koordinat untuk peta
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lahans');
    }
};

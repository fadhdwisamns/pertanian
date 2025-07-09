<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lahans', function (Blueprint $table) {
            // Tambah kolom baru setelah kolom 'no_wa'
            // Default 'Produktif' untuk data yang sudah ada
            $table->string('status_produktif')->default('Produktif')->after('no_wa');

            // Ubah kolom 'jumlah_produksi' agar bisa NULL
            $table->string('jumlah_produksi')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lahans', function (Blueprint $table) {
            $table->dropColumn('status_produktif');

            // Kembalikan kolom 'jumlah_produksi' seperti semula jika diperlukan
            $table->string('jumlah_produksi')->nullable(false)->change();
        });
    }
};
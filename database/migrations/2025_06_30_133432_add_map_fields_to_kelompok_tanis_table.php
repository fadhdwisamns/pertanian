<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelompok_tanis', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('sub_sektor');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->string('foto_lokasi')->nullable()->after('longitude');
        });
    }

    public function down(): void
    {
        Schema::table('kelompok_tanis', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'foto_lokasi']);
        });
    }
};
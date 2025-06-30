<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\CurahHujan;

class CurahHujanSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 100 data curah hujan acak
        CurahHujan::factory()->count(100)->create();
    }
}
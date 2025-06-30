<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\KelompokTani;

class KelompokTaniSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 200 data kelompok tani acak
        KelompokTani::factory()->count(200)->create();
    }
}
<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Komoditas;

class KomoditasSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 11 data komoditas unik dari factory
        Komoditas::factory()->count(11)->create();
    }
}
<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Lahan;

class LahanSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 50 data lahan acak
        Lahan::factory()->count(50)->create();
    }
}
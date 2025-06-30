<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
     public function run(): void
    {
        $this->call([
            RolesSeeder::class,          // <-- Panggil seeder role terlebih dahulu
            UserSeeder::class,           // <-- Baru panggil seeder user
            KelompokTaniSeeder::class,
            LahanSeeder::class,
            CurahHujanSeeder::class,
        ]);
    }
}

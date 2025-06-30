<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role Admin
        Role::create(['name' => 'Admin']);

        // Buat role Petani
        Role::create(['name' => 'Petani']);

        // Buat role Komoditas
        Role::create(['name' => 'Komoditas']);
    }
}
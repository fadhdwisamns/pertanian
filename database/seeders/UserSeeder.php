<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Pengguna dengan Peran Admin
        $admin = User::create([
            'name' => 'Admin Utama',
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);
        // Berikan peran 'Admin'
        $admin->assignRole('Admin');


        // 2. Buat Pengguna dengan Peran Petani
        $petani = User::create([
            'name' => 'Akun Petani',
            'username' => 'petani',
            'password' => Hash::make('password'),
        ]);
        // Berikan peran 'Petani'
        $petani->assignRole('Petani');

        // 3. Buat Pengguna dengan Peran Komoditas
        $komoditas = User::create([
            'name' => 'Akun Komoditas',
            'username' => 'komoditas',
            'password' => Hash::make('password'),
        ]);
        // Berikan peran 'Komoditas'
        $komoditas->assignRole('Komoditas');
    }
}
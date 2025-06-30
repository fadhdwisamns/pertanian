<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class LahanFactory extends Factory
{
    public function definition(): array
    {
        // CARA YANG BENAR MENGGUNAKAN SPATIE/PERMISSION
        $petani = User::role('petani')->inRandomOrder()->first();

        return [
            'user_id' => $petani ? $petani->id : User::factory(),
            'nama_lahan' => 'Lahan ' . $this->faker->lastName,
            'luas_lahan' => $this->faker->randomFloat(2, 1, 15),
            'jumlah_produksi' => $this->faker->numberBetween(2, 8) . ' Ton / Musim',
            'no_wa' => $this->faker->numerify('628##########'),
            'foto_lahan' => null,
            'latitude' => $this->faker->latitude(-0.8, -0.2),
            'longitude' => $this->faker->longitude(101.2, 101.8),
        ];
    }
}
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class KomoditasFactory extends Factory
{
    public function definition(): array
    {
        // Kita gunakan nama komoditas yang realistis
        return [
            'nama_komoditas' => $this->faker->unique()->randomElement([
                'Padi Sawah', 'Karet', 'Sawit', 'Jagung', 'Sapi', 'Kerbau',
                'Palawija', 'Hortikultura', 'Itik', 'Ayam Petelur', 'Cabe'
            ]),
        ];
    }
}
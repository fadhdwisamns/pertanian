<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class CurahHujanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tahun' => $this->faker->numberBetween(2020, 2024),
            'bulan' => $this->faker->monthName(),
            'curah_hujan_mm' => $this->faker->randomFloat(2, 80, 500),
        ];
    }
}
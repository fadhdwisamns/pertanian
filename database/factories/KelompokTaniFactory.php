<?php
namespace Database\Factories;
use App\Models\Komoditas;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelompokTaniFactory extends Factory
{
    public function definition(): array
    {
        // Ambil satu komoditas secara acak dari database untuk data yang realistis
        $komoditas = Komoditas::inRandomOrder()->first()->nama_komoditas ?? 'Padi Sawah';

        return [
            'kecamatan' => $this->faker->randomElement(['Cerenti', 'Inuman', 'Kuantan Hilir', 'Pangean', 'Logas Tanah Darat']),
            'desa' => $this->faker->city(),
            'nama_kelompok' => 'Tani Maju ' . $this->faker->word(),
            'alamat_sekretariat' => $this->faker->address(),
            'tahun_berdiri' => $this->faker->numberBetween(1990, 2024),
            'komoditas_unggulan' => $komoditas,
            'ketua_kelompok' => $this->faker->name(),
            'kelas_kemampuan' => $this->faker->randomElement(['Pemula', 'Lanjut', 'Madya']),
            'sub_sektor' => $this->faker->randomElement(['Tanaman Pangan', 'Perkebunan', 'Peternakan']),
        ];
    }
}
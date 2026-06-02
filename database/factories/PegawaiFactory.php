<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PegawaiFactory extends Factory
{
    public function definition(): array
    {
        $pangkat = [
            'Bripda',
            'Briptu',
            'Brigpol',
            'Bripka',
            'Aipda',
            'Aiptu',
            'Ipda',
            'Iptu',
            'AKP',
            'Kompol',
            'AKBP',
        ];

        $jabatan = [
            'Bamin',
            'Banit',
            'Paur',
            'Kaur',
            'Kanit',
            'Kasat',
            'Kabag',
            'Wakapolres',
            'Karo',
        ];

        $satuanKerja = [
            'Polda NTB',
            'Polresta Mataram',
            'Polres Lombok Barat',
            'Polres Lombok Tengah',
            'Polres Lombok Timur',
            'Polres Sumbawa',
            'Polres Sumbawa Barat',
            'Polres Dompu',
            'Polres Bima',
            'Polres Bima Kota',
        ];

        return [
            'nama' => fake()->name(),
            'nrp' => fake()->unique()->numerify('########'),
            'pangkat' => fake()->randomElement($pangkat),
            'jabatan' => fake()->randomElement($jabatan),
            'satuan_kerja' => fake()->randomElement($satuanKerja),
            'foto' => null,
        ];
    }
}

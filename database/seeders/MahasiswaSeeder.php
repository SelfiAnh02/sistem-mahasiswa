<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use Faker\Factory as Faker;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        for ($i = 1; $i <= 50; $i++) {
            Mahasiswa::create([
                'nim' => '2024' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nama' => $faker->name,
                'alamat' => $faker->address,
            ]);
        }
    }
}
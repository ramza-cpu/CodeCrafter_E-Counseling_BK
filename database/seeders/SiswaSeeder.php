<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ✅ penting

class SiswaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 15; $i++) {
            DB::table('siswa')->insert([
                'id_user' => $i,
                'nisn' => $faker->unique()->numerify('##########'),
                'nama' => $faker->name(),
                'kelas' => 'X-'.$faker->randomElement(['A', 'B', 'C']),
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'alamat' => $faker->address(),
                'no_hp' => '08'.$faker->numerify('##########'),
                'skor' => 100, // awal 100
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

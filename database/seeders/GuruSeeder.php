<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ✅ penting

class GuruSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 15; $i++) {
            DB::table('guru')->insert([
                'id_user' => $i,
                'nip' => $faker->unique()->numerify('##################'),
                'nama' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'no_hp' => '08'.$faker->numerify('##########'),
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrangTuaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 15; $i++) {
            DB::table('orang_tua')->insert([
                'id_siswa' => $i, // asumsi siswa sudah 15 data
                'id_user' => $i,  // asumsi user orang_tua juga 15 data
                'nama_ayah' => $faker->name('male'),
                'nama_ibu' => $faker->name('female'),

                // Nomor HP format aman (maks 13 digit)
                'no_hp' => '08'.$faker->numerify('##########'),

                'alamat' => $faker->address(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

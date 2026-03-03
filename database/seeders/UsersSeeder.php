<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    public function run()
    {
                $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 15; $i++) {
            DB::table('users')->insert([
                'username' => $faker->unique()->userName(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role' => $faker->randomElement(['admin','guru','siswa','ortu']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
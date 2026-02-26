<?php
namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $roles = ['admin', 'guru', 'ortu', 'siswa'];

        for ($i = 1; $i <= 15; $i++) {
            DB::table('users')->insert([
                'username' => $faker->unique()->userName(),
                'password' => Hash::make('password'),
                'role' => $roles[$i % 4],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

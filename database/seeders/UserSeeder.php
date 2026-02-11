<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id_user' => 1,
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'id_user' => 2,
                'username' => 'guru1',
                'password' => Hash::make('password'),
                'role' => 'guru',
            ],
            [
                'id_user' => 3,
                'username' => 'siswa1',
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ],
            [
                'id_user' => 4,
                'username' => 'ortu1',
                'password' => Hash::make('password'),
                'role' => 'ortu',
            ],
        ]);
    }
}

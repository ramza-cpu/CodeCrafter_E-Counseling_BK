<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('guru')->insert([
            [
                'id_guru' => 1,
                'user_id' => 2,
                'nip' => '198765432100000001',
                'nama' => 'Budi Santoso',
                'email' => 'budi@guru.com',
                'no_hp' => '081234567890',
                'jenis_kelamin' => 'L',
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KonselingLogSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 15; $i++) {
            DB::table('konseling_log')->insert([
                'id_session' => rand(1, 15),
                'id_siswa' => rand(1, 15),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

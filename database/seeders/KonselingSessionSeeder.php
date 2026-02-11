<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KonselingSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('konseling_session')->insert([
            [
                'id_session' => 1,
                'anonymous_code' => 'KS001',
                'nickname' => 'Anonim',
                'status' => 'aktif',
            ],
        ]);
    }
}

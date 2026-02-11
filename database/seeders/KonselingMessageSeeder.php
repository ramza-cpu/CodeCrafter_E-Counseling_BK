<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KonselingMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('konseling_message')->insert([
            [
                'id_message' => 1,
                'id_session' => 1,
                'sender' => 'siswa',
                'message' => 'Pak, saya ingin konsultasi.',
            ],
            [
                'id_message' => 2,
                'id_session' => 1,
                'sender' => 'guru',
                'message' => 'Silakan, ada yang bisa dibantu?',
            ],
        ]);
    }
}

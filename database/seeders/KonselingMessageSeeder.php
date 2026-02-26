<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
class KonselingMessageSeeder extends Seeder
{
    public function run()
    {
        $pesanSiswa = [
            'Saya merasa kesulitan belajar.',
            'Saya kurang percaya diri.',
            'Saya sulit fokus di kelas.',
        ];

        $pesanGuru = [
            'Coba atur waktu belajar.',
            'Kita bisa buat jadwal belajar.',
            'Kamu punya potensi yang baik.',
        ];

        for ($i = 1; $i <= 15; $i++) {

            DB::table('konseling_message')->insert([
                'id_session' => rand(1,15),
                'sender' => 'siswa',
                'message' => $pesanSiswa[array_rand($pesanSiswa)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('konseling_message')->insert([
                'id_session' => rand(1,15),
                'sender' => 'guru',
                'message' => $pesanGuru[array_rand($pesanGuru)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

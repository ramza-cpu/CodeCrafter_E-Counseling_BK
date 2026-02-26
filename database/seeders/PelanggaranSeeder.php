<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelanggaranSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 15; $i++) {

            $idSiswa = rand(1, 15);
            $jenis = DB::table('jenis_pelanggaran')->inRandomOrder()->first();

            DB::table('pelanggaran')->insert([
                'id_siswa' => $idSiswa,
                'id_jenis_pelanggaran' => $jenis->id_jenis_pelanggaran,
                'id_guru' => rand(1, 15),
                'tanggal' => now(),
                'poin' => $jenis->poin,
                'keterangan' => $jenis->nama_pelanggaran,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 🔥 Kurangi skor siswa otomatis
            DB::table('siswa')
                ->where('id_siswa', $idSiswa)
                ->decrement('skor', $jenis->poin);
        }
    }
}

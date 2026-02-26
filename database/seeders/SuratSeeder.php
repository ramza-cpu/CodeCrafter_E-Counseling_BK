<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuratSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $jenisSurat = [
            'Surat Peringatan 1',
            'Surat Peringatan 2',
            'Surat Panggilan Orang Tua',
        ];

        for ($i = 1; $i <= 15; $i++) {
            DB::table('surat')->insert([
                'id_siswa' => rand(1, 15),
                'id_guru' => rand(1, 15),
                'nomor_surat' => 'SR-'.$faker->unique()->numerify('####'),
                'jenis_surat' => $faker->randomElement($jenisSurat),
                'tanggal_cetak' => now(),
                'isi_surat' => 'Sehubungan dengan pelanggaran siswa, maka diberikan peringatan.',
                'status' => $faker->randomElement(['pending', 'tercetak']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

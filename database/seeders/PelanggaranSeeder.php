<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelanggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('pelanggaran')->insert([
            [
                'id_pelanggaran' => 1,
                'id_siswa' => 1,
                'id_jenis_pelanggaran' => 1,
                'id_guru' => 1,
                'tanggal' => now(),
                'poin' => 5,
                'keterangan' => 'Datang terlambat 15 menit',
            ],
        ]);
    }
}

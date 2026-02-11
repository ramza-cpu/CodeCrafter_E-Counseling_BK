<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPelanggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('jenis_pelanggaran')->insert([
            ['id_jenis_pelanggaran' => 1, 'nama_pelanggaran' => 'Terlambat', 'poin' => 5],
            ['id_jenis_pelanggaran' => 2, 'nama_pelanggaran' => 'Tidak memakai atribut', 'poin' => 10],
        ]);
    }
}

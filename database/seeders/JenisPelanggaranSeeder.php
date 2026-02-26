<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPelanggaranSeeder extends Seeder
{
    public function run()
    {
        $pelanggaranList = [
            'Terlambat masuk sekolah',
            'Tidak memakai atribut lengkap',
            'Membolos pelajaran',
            'Rambut tidak sesuai aturan',
            'Tidak mengerjakan tugas',
            'Berisik di kelas',
            'Menggunakan HP saat pelajaran',
        ];

        for ($i = 0; $i < 15; $i++) {
            DB::table('jenis_pelanggaran')->insert([
                'nama_pelanggaran' => $pelanggaranList[$i % count($pelanggaranList)],
                'poin' => rand(5, 20),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

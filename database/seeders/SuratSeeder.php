<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('surat')->insert([
            [
                'id_surat' => 1,
                'id_siswa' => 1,
                'id_guru' => 1,
                'nomor_surat' => '001/SP/2026',
                'jenis_surat' => 'Surat Peringatan',
                'tanggal_cetak' => now(),
                'isi_surat' => 'Surat peringatan karena pelanggaran disiplin.',
            ],
        ]);
    }
}

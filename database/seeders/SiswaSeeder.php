<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('siswa')->insert([
            [
                'id_siswa' => 1,
                'id_guru' => 1,
                'id_user' => 3,
                'nisn' => '1234567890',
                'nama' => 'Andi Saputra',
                'kelas' => 'XII RPL 1',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Merdeka No.1',
                'no_hp' => '081298765432',
                'skor' => 95,
                'qr_code' => null,
            ],
        ]);
    }
}

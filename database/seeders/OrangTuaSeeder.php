<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrangTuaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('orang_tua')->insert([
            [
                'id_ortu' => 1,
                'id_siswa' => 1,
                'id_user' => 4,
                'nama_ayah' => 'Rahmat Saputra',
                'nama_ibu' => 'Siti Aminah',
                'no_hp' => '081277788899',
                'alamat' => 'Jl. Merdeka No.1',
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            GuruSeeder::class,
            SiswaSeeder::class,
            OrangTuaSeeder::class,
            JenisPelanggaranSeeder::class,
            PelanggaranSeeder::class,
            SuratSeeder::class,
            KonselingSessionSeeder::class,
            KonselingMessageSeeder::class,
        ]);
    }
}

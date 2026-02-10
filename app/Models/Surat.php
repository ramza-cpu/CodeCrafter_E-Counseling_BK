<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table = 'surat';

    protected $primaryKey = 'id_surat';

    protected $fillable = [
        'id_siswa', 'id_guru', 'nomor_surat', 'jenis_surat', 'tanggal_cetak', 'isi_surat',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $primaryKey = 'id_pelanggaran';

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function jenis()
    {
        return $this->belongsTo(JenisPelanggaran::class, 'id_jenis_pelanggaran');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $table = 'pelanggaran';

    protected $primaryKey = 'id_pelanggaran';

    protected $fillable = [
        'id_siswa',
        'id_jenis_pelanggaran',
        'id_guru',
        'tanggal',
        'poin',
        'keterangan',
        'status',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function jenisPelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class, 'id_jenis_pelanggaran');
    }
}

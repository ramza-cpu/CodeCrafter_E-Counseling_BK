<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $primaryKey = 'id_siswa';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'id_siswa');
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class, 'id_siswa');
    }

    public function surat()
    {
        return $this->hasMany(Surat::class, 'id_siswa');
    }
}

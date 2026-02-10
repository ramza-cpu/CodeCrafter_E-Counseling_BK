<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey = 'id_user';

    public function guru()
    {
        return $this->hasOne(Guru::class, 'user_id');
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'id_user');
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'id_user');
    }
}

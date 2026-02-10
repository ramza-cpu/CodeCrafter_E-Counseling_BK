<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $primaryKey = 'id_guru';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_guru');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonselingLog extends Model
{
    protected $table = 'konseling_log';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_session','id_siswa'
    ];
}


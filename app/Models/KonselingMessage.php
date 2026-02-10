<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonselingMessage extends Model
{
    protected $table = 'konseling_message';
    protected $primaryKey = 'id_message';

    protected $fillable = [
        'id_session','sender','message'
    ];
}

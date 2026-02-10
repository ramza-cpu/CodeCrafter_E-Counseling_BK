<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonselingSession extends Model
{
    protected $primaryKey = 'id_session';

    public function messages()
    {
        return $this->hasMany(KonselingMessage::class, 'id_session');
    }

    public function logs()
    {
        return $this->hasMany(KonselingLog::class, 'id_session');
    }
}

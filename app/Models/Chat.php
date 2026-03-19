<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats'; // 🔥 TAMBAHKAN INI

    protected $primaryKey = 'id_chat'; // kalau pakai id_chat

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'id_siswa',
        'id_user_tujuan',
        'nama_anonim',
        'is_anonymous',
        'last_message',
        'last_time',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class, 'id_chat');
    }

    public function siswa()
    {
        return $this->belongsTo(\App\Models\Siswa::class, 'id_siswa');
    }

    public function tujuan()
    {
        return $this->belongsTo(User::class, 'id_user_tujuan');
    }
}

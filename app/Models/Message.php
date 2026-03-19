<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $primaryKey = 'id_message';

    protected $fillable = [
        'id_chat',
        'sender_id',
        'sender_role',
        'message',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class, 'id_chat');
    }
}

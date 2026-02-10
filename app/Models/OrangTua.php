<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrangTua extends Model
{
    protected $table = 'orang_tua';

    protected $primaryKey = 'id_ortu';

    protected $fillable = [
        'id_siswa', 'id_user', 'nama_ayah', 'nama_ibu', 'no_hp', 'alamat',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}

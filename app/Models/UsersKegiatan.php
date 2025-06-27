<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersKegiatan extends Model
{
    protected $table = 'users_kegiatan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'kegiatan_id',
    ];

    public function user()
    {
       

 return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id', 'kegiatan_id');
    }
}

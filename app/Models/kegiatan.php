<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class kegiatan extends Model
{

    protected $table = 'kegiatan';
    protected $primaryKey = 'kegiatan_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kegiatan_id',
        'judul',
        'deskripsi',
        'gambar_kegiatan',
        'kuota',
        'status',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }

    public function usersKegiatans()
    {
        return $this->hasMany(UsersKegiatan::class, 'kegiatan_id', 'kegiatan_id');
    }

    public function isEditable()
    {
        return $this->status !== 'approved';
    }

    public function getTotalPesertaAttribute()
    {
        return $this->usersKegiatans()->count();
    }

    public function isKuotaPenuh()
    {
        return $this->getTotalPesertaAttribute() >= $this->kuota;
    }

    public function delete()
    {
        if ($this->gambar_kegiatan) {
            Storage::delete(str_replace('storage/', 'public/', $this->gambar_kegiatan));
        }
        return parent::delete();
    }

}

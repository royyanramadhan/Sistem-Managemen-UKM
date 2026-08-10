<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Ukm extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'logo',
        'bidang',
        'email',
        'telepon',
        'alamat',
        'status',
        'link_pendaftaran',
    ];

public function kepengurusans(): HasMany
    {
        return $this->hasMany(Kepengurusan::class);
    }

    public function divisis(): HasMany
    {
        return $this->hasMany(Divisi::class);
    }

    public function anggota()
    {
        return $this->hasManyThrough(User::class, Kepengurusan::class);
    }

    public function ketua()
    {
        return $this->hasOneThrough(
            User::class,
            Kepengurusan::class,
            'ukm_id',
            'id',
            'id',
            'user_id'
        )->whereIn('kepengurusans.jabatan_id', function ($query) {
            $query->select('id')->from('jabatans')->where('nama', 'Ketua Umum');
        })->where('kepengurusans.status', 'aktif');
    }

    public function kegiatans(): HasMany
    {
        return $this->hasMany(Kegiatan::class);
    }

    public function keanggotaans(): HasMany
    {
        return $this->hasMany(Keanggotaan::class);
    }

    public function prestasis(): HasMany
    {
        return $this->hasMany(Prestasi::class);
    }

    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class);
    }
}

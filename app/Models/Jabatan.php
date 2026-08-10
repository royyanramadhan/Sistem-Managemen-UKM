<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jabatan extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'level',
    ];

    public function kepengurusans(): HasMany
    {
        return $this->hasMany(Kepengurusan::class);
    }
}

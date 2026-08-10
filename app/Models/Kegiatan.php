<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kegiatan extends Model
{
    protected $fillable = [
        'ukm_id',
        'nama',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'tempat',
        'jenis',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function ukm(): BelongsTo
    {
        return $this->belongsTo(Ukm::class);
    }
}


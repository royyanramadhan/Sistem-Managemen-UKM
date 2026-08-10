<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prestasi extends Model
{
    protected $fillable = [
        'ukm_id',
        'user_id',
        'nama_prestasi',
        'tingkat',
        'tanggal',
        'deskripsi',
        'piagam',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function ukm(): BelongsTo
    {
        return $this->belongsTo(Ukm::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}


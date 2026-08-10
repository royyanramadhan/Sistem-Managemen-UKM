<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keanggotaan extends Model
{
    protected $fillable = [
        'user_id',
        'ukm_id',
        'tanggal_daftar',
        'status',
        'alasan',
        'no_hp',
        'fakultas',
        'program_studi',
        'angkatan',
        'ktm',
        'alasan_penolakan',
    ];

    protected $casts = [
        'tanggal_daftar' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ukm(): BelongsTo
    {
        return $this->belongsTo(Ukm::class);
    }
}

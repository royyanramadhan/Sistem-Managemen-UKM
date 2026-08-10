<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kepengurusan extends Model
{
protected $fillable = [
        'ukm_id',
        'user_id',
        'jabatan_id',
        'divisi_id',
        'tanggal_mulai',
        'tanggal_akhir',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
    ];

    public function ukm(): BelongsTo
    {
        return $this->belongsTo(Ukm::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class);
    }
}

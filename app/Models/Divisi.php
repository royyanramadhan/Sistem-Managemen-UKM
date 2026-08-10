<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Divisi extends Model
{
    protected $fillable = [
        'ukm_id',
        'nama',
        'status',
    ];

    public function ukm(): BelongsTo
    {
        return $this->belongsTo(Ukm::class);
    }

    public function kepengurusans(): HasMany
    {
        return $this->hasMany(Kepengurusan::class);
    }
}

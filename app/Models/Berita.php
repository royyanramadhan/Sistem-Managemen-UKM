<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Berita extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'gambar',
        'isi',
        'ukm_id',
        'kategori',
        'tanggal_publikasi',
        'status',
        'tampil_di_dashboard',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'date',
        'tampil_di_dashboard' => 'boolean',
    ];

    public function ukm(): BelongsTo
    {
        return $this->belongsTo(Ukm::class);
    }
}

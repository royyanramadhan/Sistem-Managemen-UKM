<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tambah status 'keluar' ke tabel kepengurusans dan keanggotaans.
     *
     * Laravel memerlukan doctrine/dbal untuk ->change() pada enum.
     * Karena doctrine/dbal tidak terpasang (> doctrine/dbal 4 tidak lagi
     * mendukung Laravel < 11), kita gunakan raw SQL DB::statement() sebagai
     * alternatif yang lebih aman dan portabel (MySQL / MariaDB).
     */
    public function up(): void
    {
        // Perluas enum kepengurusans.status menjadi [aktif, nonaktif, keluar]
        DB::statement("ALTER TABLE kepengurusans MODIFY COLUMN status ENUM('aktif', 'nonaktif', 'keluar') NOT NULL DEFAULT 'aktif'");

        // Perluas enum keanggotaans.status menjadi [pending, diterima, ditolak, keluar]
        DB::statement("ALTER TABLE keanggotaans MODIFY COLUMN status ENUM('pending', 'diterima', 'ditolak', 'keluar') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE kepengurusans MODIFY COLUMN status ENUM('aktif', 'nonaktif') NOT NULL DEFAULT 'aktif'");
        DB::statement("ALTER TABLE keanggotaans MODIFY COLUMN status ENUM('pending', 'diterima', 'ditolak') NOT NULL DEFAULT 'pending'");
    }
};

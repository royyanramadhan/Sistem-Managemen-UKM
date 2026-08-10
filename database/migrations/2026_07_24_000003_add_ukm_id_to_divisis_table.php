<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('divisis', function (Blueprint $table) {
            // Hapus unique constraint pada kolom nama (agar nama divisi bisa sama antar UKM)
            $table->dropUnique(['nama']);

            // Tambah kolom ukm_id (nullable, karena sesi lama tanpa UKM)
            $table->foreignId('ukm_id')->nullable()->after('id')
                ->constrained('ukms')->cascadeOnDelete();

            // Nama divisi unik dalam satu UKM
            $table->unique(['ukm_id', 'nama']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('divisis', function (Blueprint $table) {
            $table->dropUnique(['ukm_id', 'nama']);
            $table->dropForeign(['ukm_id']);
            $table->dropColumn('ukm_id');
            $table->unique(['nama']);
        });
    }
};

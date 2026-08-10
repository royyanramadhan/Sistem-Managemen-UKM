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
        Schema::table('keanggotaans', function (Blueprint $table) {
            $table->text('alasan')->nullable()->after('status');
            $table->string('asal_daerah')->nullable()->after('alasan');
            $table->text('prestasi')->nullable()->after('asal_daerah');
            $table->text('pengalaman')->nullable()->after('prestasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keanggotaans', function (Blueprint $table) {
            $table->dropColumn(['alasan', 'asal_daerah', 'prestasi', 'pengalaman']);
        });
    }
};

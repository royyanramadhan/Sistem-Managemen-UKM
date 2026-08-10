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
            // Ubah status menjadi alur pendaftaran yang benar
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending')->change();

            // Field pendaftaran baru
            $table->string('no_hp')->nullable()->after('status');
            $table->string('fakultas')->nullable()->after('no_hp');
            $table->string('program_studi')->nullable()->after('fakultas');
            $table->string('angkatan', 4)->nullable()->after('program_studi');
            $table->string('ktm')->nullable()->after('angkatan');
            $table->text('alasan_penolakan')->nullable()->after('ktm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keanggotaans', function (Blueprint $table) {
            $table->dropColumn(['no_hp', 'fakultas', 'program_studi', 'angkatan', 'ktm', 'alasan_penolakan']);
            $table->enum('status', ['aktif', 'nonaktif', 'pending'])->default('pending')->change();
        });
    }
};

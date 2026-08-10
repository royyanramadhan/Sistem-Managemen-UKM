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
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ukm_id')->constrained('ukms')->onDelete('cascade');
            $table->string('nama', 200);
            $table->text('deskripsi')->nullable();
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai')->nullable();
            $table->string('tempat', 200)->nullable();
            $table->enum('jenis', ['kegiatan', 'rapat', 'pelatihan', 'lomba'])->default('kegiatan');
            $table->enum('status', ['direncanakan', 'berlangsung', 'selesai'])->default('direncanakan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};


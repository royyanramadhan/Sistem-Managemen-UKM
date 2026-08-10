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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ukm_id')->nullable()->constrained('ukms')->nullOnDelete();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('gambar')->nullable();
            $table->text('isi');
            $table->string('kategori')->nullable();
            $table->date('tanggal_publikasi')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->boolean('tampil_di_dashboard')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};

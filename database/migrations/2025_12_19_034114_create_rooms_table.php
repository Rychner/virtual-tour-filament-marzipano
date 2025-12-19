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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // Nama ruangan (Dosen A, dll)
            $table->string('slug')->unique();       // dosen-a
            $table->string('category');             // dosen, rapat, kelas

            // Relasi ke panorama
            $table->foreignId('panorama_id')->constrained()->cascadeOnDelete();

            // Relasi ke hotspot (opsional tapi sesuai kebutuhan kamu)
            $table->foreignId('hotspot_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room');
    }
};

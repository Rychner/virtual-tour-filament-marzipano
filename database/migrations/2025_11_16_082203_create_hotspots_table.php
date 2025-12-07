<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hotspots', function (Blueprint $table) {
            $table->id();

            // Relasi ke panorama asal
            $table->foreignId('panorama_id')->constrained()->cascadeOnDelete();

            // Hotspot position in panorama
            $table->float('yaw');     // posisi horizontal
            $table->float('pitch');   // posisi vertical

            $table->string('type')->default('link'); // future: info, image, video
            $table->string('label')->nullable();

            // Link ke panorama tujuan
            $table->foreignId('target_panorama_id')
                ->nullable()
                ->constrained('panoramas')
                ->nullOnDelete();
            
            $table->string('icon_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hotspots');
    }
};
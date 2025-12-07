<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('panoramas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image_path'); // file panorama (jpg)
            $table->text('description')->nullable();

            // Initial view configuration
            $table->float('initial_yaw')->default(0);
            $table->float('initial_pitch')->default(0);
            $table->float('initial_fov')->default(90);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panoramas');
    }
};

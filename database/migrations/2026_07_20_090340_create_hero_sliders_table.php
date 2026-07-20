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
        Schema::create('hero_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image_path'); // Path to hero slider image
            $table->string('video_url')->nullable(); // Optional video URL or path
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('button_text')->default('Start Shopping');
            $table->string('button_link')->default('/shop');
            $table->integer('order')->default(0); // For ordering sliders
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_sliders');
    }
};

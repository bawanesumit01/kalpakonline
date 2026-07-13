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
        Schema::create('marquee_messages', function (Blueprint $table) {
            $table->id();
            $table->text('message'); // Support longer messages
            $table->string('icon')->nullable()->default('fa-solid fa-star'); // Font Awesome icon class
            $table->integer('order')->default(0); // Order to display messages
            $table->boolean('is_active')->default(true); // Enable/disable individual messages
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marquee_messages');
    }
};

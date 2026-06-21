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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->string('address_line2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('country')->default('India');
            
            $table->boolean('is_default')->default(false);
            $table->enum('address_type', ['home', 'work', 'other'])->default('home');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};

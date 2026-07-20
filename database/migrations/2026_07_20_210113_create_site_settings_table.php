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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_path')->nullable()->comment('Path to site logo');
            $table->string('site_name')->default('Kalpak Online')->comment('Website name');
            $table->text('site_description')->nullable()->comment('Website description');
            $table->string('phone')->nullable()->comment('Primary phone number');
            $table->string('email')->nullable()->comment('Support email');
            $table->string('address')->nullable()->comment('Office address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};

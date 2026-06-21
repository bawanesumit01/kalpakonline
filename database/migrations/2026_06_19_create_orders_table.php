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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable();
            
            // Customer Info
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            
            // Address Info
            $table->unsignedBigInteger('user_address_id')->nullable();
            $table->foreign('user_address_id')->references('id')->on('user_addresses')->onDelete('set null');
            $table->text('address');
            $table->string('address_line2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('country');
            
            // Payment & Order Details
            $table->enum('payment_method', ['cod', 'online', 'wallet'])->default('cod');
            $table->text('order_notes')->nullable();
            $table->string('promo_code')->nullable();
            $table->decimal('discount', 10, 2)->default(0);
            
            // Pricing
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('total', 10, 2);
            
            // Status
            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            
            // Tracking
            $table->string('tracking_number')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->index(['phone']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

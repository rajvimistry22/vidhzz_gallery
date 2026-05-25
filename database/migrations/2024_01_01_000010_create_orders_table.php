<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->foreignId('coupon_id')->nullable()->constrained()->onDelete('set null');
            $table->string('order_number')->unique();
            $table->enum('status', [
                'pending','confirmed','processing','shipped','delivered','cancelled','refunded'
            ])->default('pending');
            $table->enum('payment_status', ['pending','paid','failed','refunded'])->default('pending');
            $table->string('payment_method')->default('razorpay');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('shipping_charge', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('coupon_code')->nullable();
            // Shipping address snapshot
            $table->string('shipping_name');
            $table->string('shipping_phone');
            $table->string('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_state');
            $table->string('shipping_pincode');
            $table->string('shipping_country')->default('India');
            $table->text('notes')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->string('tracking_number')->nullable();
            $table->timestamps();

            $table->index('order_number');
            $table->index('user_id');
            $table->index('status');
            $table->index('payment_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

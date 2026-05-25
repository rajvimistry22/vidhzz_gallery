<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('subcategory')->nullable()->after('sku');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('billing_name')->nullable()->after('shipping_country');
            $table->string('billing_phone')->nullable()->after('billing_name');
            $table->string('billing_address')->nullable()->after('billing_phone');
            $table->string('billing_city')->nullable()->after('billing_address');
            $table->string('billing_state')->nullable()->after('billing_city');
            $table->string('billing_pincode')->nullable()->after('billing_state');
            $table->string('billing_country')->default('India')->after('billing_pincode');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'billing_name',
                'billing_phone',
                'billing_address',
                'billing_city',
                'billing_state',
                'billing_pincode',
                'billing_country',
            ]);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('subcategory');
        });
    }
};

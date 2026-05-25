<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->string('unit')->default('piece');
            $table->string('weight')->nullable();
            $table->json('sizes')->nullable();
            $table->json('colors')->nullable();
            $table->string('material')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->unsignedInteger('views')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('category_id');
            $table->index('is_featured');
            $table->index('is_trending');
            $table->index('is_active');
            $table->index(['price', 'sale_price']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

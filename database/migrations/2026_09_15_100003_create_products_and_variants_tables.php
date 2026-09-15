<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->longText('description')->nullable();
            $table->text('short_description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('fabric')->nullable();
            $table->string('colour')->nullable();
            $table->string('pattern')->nullable();
            $table->string('work')->nullable();
            $table->string('occasion')->nullable();
            $table->text('care_instructions')->nullable();
            $table->decimal('weight', 8, 2)->nullable()->comment('Weight in grams or kg');
            $table->integer('stock')->default(0);
            $table->integer('low_stock_threshold')->default(5);
            $table->enum('status', ['draft', 'published', 'archived'])->default('published');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_best_seller')->default(false);
            $table->boolean('is_new')->default(true);
            $table->boolean('is_sale')->default(false);
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['category_id', 'status']);
            $table->index('is_featured');
            $table->index('is_best_seller');
        });

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('image_path');
            $table->string('alt_text')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('sku')->unique();
            $table->string('size')->nullable();
            $table->string('colour')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['product_id', 'size', 'colour']);
        });

        Schema::create('collection_product', function (Blueprint $table) {
            $table->foreignId('collection_id')->constrained('collections')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->primary(['collection_id', 'product_id']);
        });

        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('cascade');
            $table->enum('type', ['purchase', 'order', 'cancellation', 'return', 'manual_adjustment']);
            $table->integer('quantity')->comment('Can be negative or positive');
            $table->integer('balance_after');
            $table->string('reason')->nullable();
            $table->string('reference_id')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
        Schema::dropIfExists('collection_product');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
    }
};

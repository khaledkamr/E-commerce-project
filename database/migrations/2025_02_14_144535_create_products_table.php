<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Name	Price	SalePrice	SKU	Category	Brand	Featured	Stock	Quantity
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug")->unique();
            $table->string("short_description")->nullable();
            $table->text("description");
            $table->decimal("regular_price", 10, 2);
            $table->decimal("sale_price", 10, 2)->nullable();
            $table->string("SKU")->unique();
            $table->enum("stock_status", ["inStock", "outStock"]);
            $table->boolean("Featured")->default(false);
            $table->unsignedInteger("Quantity")->default(10);
            $table->string("image")->nullable();
            $table->text("images")->nullable();
            $table->unsignedBigInteger("category_id")->nullable();
            $table->unsignedBigInteger("brand_id")->nullable();
            $table->timestamps();
            $table->foreign("category_id")->references("id")->on("categories")->onDelete("cascade");
            $table->foreign("brand_id")->references("id")->on("brands")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

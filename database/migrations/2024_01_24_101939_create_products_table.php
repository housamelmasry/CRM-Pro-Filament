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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->String('name');
            $table->foreignId('category_id')->references('id')->on('categories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->Integer('available_qty');
            $table->decimal('price', 8, 2);
            $table->decimal('cost', 8, 2);
            $table->String('brand');
            // $table->Bit('photo',100);   // morphs
            // $table->String('status',5);
            $table->dateTime('last_order_date');
            $table->dateTime('date_added');
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();//Relationship
            $table->timestamps();
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('category_product');
    }
};

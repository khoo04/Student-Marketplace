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
        Schema::create('order_product', function (Blueprint $table) {
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("order_id");
            //Order ID and Product ID must be Foreign Key
            $table->primary(['product_id','order_id']);

            // Foreign key constraints
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->integer('quantity');
            //TODO: Change the meaningful status
            $table->enum('order_status',['processing','shipping','completed']);
            $table->boolean("comments_status")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};

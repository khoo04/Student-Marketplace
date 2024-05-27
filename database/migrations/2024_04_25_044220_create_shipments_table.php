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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->enum("status",["pending","shipping","cancelled","completed"])->default("pending");
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp("ship_out_date")->nullable();     
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_id');
            //Foreign Key Constraint
            $table->foreign('address_id')->references('id')->on('shipping_address');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};

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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal("total_payment",total: 8, places: 2);
            $table->string('transaction_no')->nullable();
            $table->enum("payment_status",["pending","success","failed"])->default("pending");
            $table->timestamp("created_at")->useCurrent();
            $table->timestamp("updated_at")->useCurrent();
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("user_id");
            $table->boolean("isPaid")->nullable();
            $table->foreign("order_id")->references("id")->on("orders");
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

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
            $table->string('name');
            $table->longText('description');
            $table->integer('quantity_available');
            $table->decimal('price',total: 8, places: 2);
            $table->double('rating')->nullable()->default(0)->comment('Rating value from 0 to 5');
            $table->enum('condition',['used','new']);
            $table->string('images')->nullable();
            $table->enum('approve_status',['approved','pending','rejected'])->default('pending');
            $table->timestamp('created_at')->nullable(); 
            $table->timestamp('updated_at')->nullable(); 
            $table->softDeletes();
            //Foreign Key
            $table->unsignedBigInteger("category_id");
            $table->unsignedBigInteger("user_id");
            //Constraint
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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

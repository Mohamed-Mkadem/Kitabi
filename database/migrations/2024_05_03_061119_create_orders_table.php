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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status', ['pending', 'cancelled', 'confirmed', 'shipped', 'delivered', 'returned'])->default('pending');
            $table->unsignedInteger('amount');
            $table->unsignedSmallInteger('no_of_items');
            $table->text('note')->nullable();
            $table->foreignId('state_id')->constrained('states');
            $table->foreignId('city_id')->constrained('cities');
            $table->string('customer_name');
            $table->integer('shipping_cost');
            $table->string('shipping_address');
            $table->string('customer_phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

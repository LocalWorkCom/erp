<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('point_systems', function (Blueprint $table) {
            $table->id();  // Unique identifier for the transaction
            $table->foreignId('customer_id')->constrained('customers')->onDelete('set null');  // Links to the customer
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');  // Links to the order, if applicable
            $table->enum('type', ['earn', 'redeem']);  // Type of transaction (earn or redeem)
            $table->integer('points');  // Number of points earned or redeemed
            $table->decimal('amount', 10, 2)->nullable();  // Amount associated with the transaction (e.g., discount)
            $table->timestamp('transaction_date')->useCurrent();  // Date and time of the transaction
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('point_systems');
    }
};

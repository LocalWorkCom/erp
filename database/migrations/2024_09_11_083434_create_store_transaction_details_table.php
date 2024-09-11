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
        Schema::create('store_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_transactions_id');
            $table->unsignedBigInteger('products_id');
            $table->unsignedBigInteger('units_id');
            $table->unsignedBigInteger('countries_id')->comment('to get currency id');
            $table->double('count', 15,2)->default(0);
            $table->decimal('price', 8,2)->default(0);
            $table->double('total', 15,2)->default(0);
            $table->timestamps();

            $table->foreign('store_transactions_id')->references('id')->on('store_transactions')->opUpdate('cascade');
            $table->foreign('products_id')->references('id')->on('products')->onUpdate('cascade');
            $table->foreign('units_id')->references('id')->on('units')->onUpdate('cascade');
            $table->foreign('countries_id')->references('id')->on('countries')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_transaction_details');
    }
};

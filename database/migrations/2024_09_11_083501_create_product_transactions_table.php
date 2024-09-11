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
        Schema::create('product_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('products_id');
            $table->unsignedInteger('stores_id');
            $table->integer('count');
            $table->timestamps();

            $table->foreign('products_id')->references('id')->on('prosucts')->onUpdate('cascade');
            $table->foreign('stores_id')->references('id')->on('stores')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_transactions');
    }
};

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
        Schema::create('store_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('creator_by')->comment('user id from users');
            $table->unsignedInteger('to_id')->comment('store id from stores');
            $table->enum('type', [1,2])->default(1)->comment('1 for outgoing, 2 for incoming');
            $table->enum('to', [1,2,3,4])->default(1)->comment('1 for outging from store, 2 for incoming to store, 3 for outgoing bill sale, 4 for incoming bill sale');
            $table->date('date');
            $table->integer('total')->default(0);
            $table->timestamps();

            $table->foreign('creator_by')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('to_id')->references('id')->on('stores')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_transactions');
    }
};

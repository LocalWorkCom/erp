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
        Schema::create('shelves', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->unsignedBigInteger('division_id'); 
            $table->string('name_en'); 
            $table->string('name_ar'); 
            $table->timestamps(); 

            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelves');
    }
};

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
        Schema::create('divisions', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->unsignedBigInteger('line_id'); 
            $table->string('name_en'); 
            $table->string('name_ar'); 
            $table->timestamps(); 

            $table->foreign('line_id')->references('id')->on('lines')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};

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
        Schema::create('stores', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('branch_id'); 
            $table->string('name_en')->nullable(); 
            $table->string('name_ar'); 
            $table->text('description_en')->nullable(); 
            $table->text('description_ar')->nullable(); 
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('deleted_by');
    
            $table->foreign('branch_id')->references('id')->on('branches'); 
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
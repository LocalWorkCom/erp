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
        Schema::create('branches', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('name_en'); 
            $table->string('name_ar'); 
            $table->text('address_en')->nullable(); 
            $table->text('address_ar')->nullable(); 
            $table->string('country');
            $table->string('phone')->nullable(); 
            $table->string('email')->nullable(); 
            $table->string('manager_name_en')->nullable(); 
            $table->string('manager_name_ar')->nullable(); 
            $table->string('opening_hours')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};

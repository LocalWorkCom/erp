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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->string('image')->nullable();
            $table->enum('flag', ['dish', 'offer'])->default('dish');
            $table->unsignedBigInteger('dish_id')->nullable();
            $table->unsignedBigInteger('offer_id')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnUpdate();
            $table->foreignId('modified_by')->nullable()->constrained('users')->cascadeOnUpdate();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
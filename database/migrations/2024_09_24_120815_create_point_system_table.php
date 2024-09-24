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
            //this table to define points and the method of calculating points based on the invoice or product and the method of calculating by percentage or currency and the value of calculating the point
            $table->id();
            $table->enum('name', ['byOrder', 'byProduct'])->nullable();
            $table->enum('key', ['percentage', 'currency'])->nullable();
            $table->string('value');
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

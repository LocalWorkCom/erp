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
        Schema::table('branches', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
        });
    
        Schema::table('countries', function (Blueprint $table) {
            $table->dropPrimary();
            $table->uuid('id')->primary()->unique()->index()->change();
        });
    
        Schema::table('branches', function (Blueprint $table) {
            $table->char('country_id', 36)->change();
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->id()->change();
        });
    }
};

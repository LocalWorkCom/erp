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
        Schema::table('shelves', function (Blueprint $table) {
            $table->softDeletes(); // Adds the deleted_at column for soft deletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shelves', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Drops the deleted_at column if the migration is rolled back
        });
    }
};
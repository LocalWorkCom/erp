<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('dishes', function (Blueprint $table) {
            $table->boolean('has_sizes')->default(0)->after('is_active'); 
        });
    }

    public function down(): void {
        Schema::table('dishes', function (Blueprint $table) {
            $table->dropColumn('has_sizes');
        });
    }
};

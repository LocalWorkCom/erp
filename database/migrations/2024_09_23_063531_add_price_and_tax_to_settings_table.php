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
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('tax_application')->default('0')
                ->comment('0:tax not included, 1:tax included');
            $table->decimal('tax_percentage', 5, 2)->default(0);

            $table->enum('pricing_method', ['original_price', 'avg_price', 'new_price'])
                ->default('avg_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('stock_transfer_method');
            $table->dropColumn('tax_application');
            $table->dropColumn('tax_percentage');
            $table->dropColumn('price_method');
        });
    }
};

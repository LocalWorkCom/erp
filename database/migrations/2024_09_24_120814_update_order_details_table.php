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
        Schema::table('order_details', function (Blueprint $table) {
            if (Schema::hasColumn('order_details', 'addon_id')) {
                $table->dropForeign(['addon_id']);
                $table->dropColumn('addon_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            // Drop the JSON `addon_id` column
            $table->dropColumn('addon_id');
        });

        Schema::table('order_details', function (Blueprint $table) {
            // Restore the `addon_id` column as unsignedBigInteger
            $table->unsignedBigInteger('addon_id');

            // Re-add the foreign key constraint
            $table->foreign('addon_id')->references('id')->on('addons');
        });
    }
};

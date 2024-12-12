<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDishAddonIdToNotNullInOrderAddons extends Migration
{
    public function up()
    {
        Schema::table('order_addons', function (Blueprint $table) {
            // Modify the column to be not nullable
            $table->unsignedBigInteger('dish_addon_id')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('order_addons', function (Blueprint $table) {
            // Revert the column to be nullable in case of rollback
            $table->unsignedBigInteger('dish_addon_id')->nullable()->change();
        });
    }
}

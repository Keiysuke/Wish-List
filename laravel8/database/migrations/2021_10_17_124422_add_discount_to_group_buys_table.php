<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountToGroupBuysTable extends Migration
{
    public function up()
    {
        Schema::table('group_buys', function (Blueprint $table) {
            $table->tinyInteger('discount')->after('global_cost')->default('0');
        });
    }

    public function down()
    {
        Schema::table('group_buys', function (Blueprint $table) {
            $table->dropColumn('discount');
        });
    }
}

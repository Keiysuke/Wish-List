<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCanSellToWebsitesTable extends Migration
{
    public function up()
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->tinyInteger('can_sell')->after('url')->default('0');
        });
    }

    public function down()
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn('can_sell');
        });
    }
}

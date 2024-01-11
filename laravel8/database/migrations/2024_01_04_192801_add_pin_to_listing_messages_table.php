<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPinToListingMessagesTable extends Migration
{
    public function up()
    {
        Schema::table('listing_messages', function (Blueprint $table) {
            $table->tinyInteger('pin')->after('message')->default('0');
        });
    }

    public function down()
    {
        Schema::table('listing_messages', function (Blueprint $table) {
            $table->dropColumn('pin');
        });
    }
}

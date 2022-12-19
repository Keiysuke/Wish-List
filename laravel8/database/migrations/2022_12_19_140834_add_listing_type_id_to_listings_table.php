<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddListingTypeIdToListingsTable extends Migration
{
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->unsignedInteger('listing_type_id')->after('user_id')->default(1);
            $table->foreign('listing_type_id')
                ->references('id')
                ->on('listing_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropForeign(['listing_type_id']);
            $table->dropColumn('listing_type_id');
        });
    }
}

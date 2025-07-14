<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCityIdToPublishersAndDropCountryColumn extends Migration
{
    public function up()
    {
        Schema::table('publishers', function (Blueprint $table) {
            $table->unsignedInteger('city_id')->nullable()->after('founded_year');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
            $table->dropColumn('country');
        });
    }

    public function down()
    {
        Schema::table('publishers', function (Blueprint $table) {
            $table->string('country', 100)->default('Inconnu')->after('founded_year');
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
        });
    }
}

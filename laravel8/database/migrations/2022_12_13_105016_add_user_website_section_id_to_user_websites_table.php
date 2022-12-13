<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserWebsiteSectionIdToUserWebsitesTable extends Migration
{
    public function up()
    {
        Schema::table('user_websites', function (Blueprint $table) {
            $table->longText('custom_url')->after('ordered')->nullable();
            $table->unsignedInteger('user_website_section_id')->after('website_id')->default(1);
            $table->foreign('user_website_section_id')
                ->references('id')
                ->on('user_website_sections')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table('user_websites', function (Blueprint $table) {
            $table->dropForeign(['user_website_section_id']);
        });
    }
}

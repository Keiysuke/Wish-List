<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWebsiteSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('user_website_sections', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', 20)->unique();
            $table->string('icon', 20)->unique();
            $table->unsignedInteger('bg_css_color_id');
            $table->foreign('bg_css_color_id')
                ->references('id')
                ->on('css_colors')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_website_sections');
    }
}

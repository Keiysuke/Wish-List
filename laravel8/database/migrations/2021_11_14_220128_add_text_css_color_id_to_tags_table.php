<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTextCssColorIdToTagsTable extends Migration
{
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->unsignedInteger('text_css_color_id')->after('border_css_color_id')->default(1);
            $table->foreign('text_css_color_id')
                ->references('id')
                ->on('css_colors')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign(['text_css_color_id']);
            $table->dropColumn('text_css_color_id');
        });
    }
}

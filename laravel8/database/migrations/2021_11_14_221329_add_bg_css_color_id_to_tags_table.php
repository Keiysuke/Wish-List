<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBgCssColorIdToTagsTable extends Migration
{
    public function up()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->unsignedInteger('bg_css_color_id')->after('text_css_color_id')->default(1);
            $table->foreign('bg_css_color_id')
                ->references('id')
                ->on('css_colors')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropForeign(['bg_css_color_id']);
            $table->dropColumn('bg_css_color_id');
        });
    }
}

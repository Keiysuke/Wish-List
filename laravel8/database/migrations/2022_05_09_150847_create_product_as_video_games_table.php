<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAsVideoGamesTable extends Migration
{
    public function up()
    {
        Schema::create('product_as_video_games', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('video_game_id');
            $table->foreign('video_game_id')
                ->references('id')
                ->on('video_games')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('vg_support_id');
            $table->foreign('vg_support_id')
                ->references('id')
                ->on('vg_supports')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_as_video_games');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoGamesTable extends Migration
{
    public function up()
    {
        Schema::create('video_games', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('vg_developer_id');
            $table->foreign('vg_developer_id')
                ->references('id')
                ->on('vg_developers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->longText('label');
            $table->date('date_released');
            $table->integer('nb_players')->default(1);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('video_games');
    }
}

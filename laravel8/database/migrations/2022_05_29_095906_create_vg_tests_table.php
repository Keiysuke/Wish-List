<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVgTestsTable extends Migration
{
    public function up()
    {
        Schema::create('vg_tests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedInteger('website_id');
            $table->foreign('website_id')
                ->references('id')
                ->on('websites')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('video_game_id');
            $table->foreign('video_game_id')
                ->references('id')
                ->on('video_games')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->longText('strong')->nullable();
            $table->longText('weak')->nullable();
            $table->integer('mark')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vg_tests');
    }
}

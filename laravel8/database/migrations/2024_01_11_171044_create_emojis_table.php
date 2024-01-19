<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmojisTable extends Migration
{
    public function up()
    {
        Schema::create('emojis', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', 25);
            $table->unsignedTinyInteger('emoji_section_id');
            $table->foreign('emoji_section_id')
                ->references('id')
                ->on('emoji_sections')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emojis');
    }
}

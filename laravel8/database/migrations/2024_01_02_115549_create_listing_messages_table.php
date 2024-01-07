<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('listing_messages', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('listing_id');
            $table->foreign('listing_id')
                ->references('id')
                ->on('listings')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->longText('message')->nullable();
            $table->unsignedInteger('answer_to_id')->nullable();
            $table->foreign('answer_to_id')
                ->references('id')
                ->on('listing_messages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('listing_messages');
    }
}

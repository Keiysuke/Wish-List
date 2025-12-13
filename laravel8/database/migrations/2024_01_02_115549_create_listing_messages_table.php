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
            $table->unsignedBigInteger('user_id');
            $table->longText('message')->nullable();
            $table->unsignedInteger('answer_to_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('listing_messages');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListMsgReactionsTable extends Migration
{
    public function up()
    {
        Schema::create('list_msg_reactions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('list_msg_id');
            $table->foreign('list_msg_id')
                ->references('id')
                ->on('listing_messages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('emoji_id');
            $table->foreign('emoji_id')
                ->references('id')
                ->on('emojis')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->primary(['list_msg_id', 'emoji_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('list_msg_reactions');
    }
}

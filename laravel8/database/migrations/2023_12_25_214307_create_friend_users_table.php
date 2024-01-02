<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFriendUsersTable extends Migration
{
    public function up()
    {
        Schema::create('friend_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('friend_id');
            $table->foreign('friend_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('favorite')->default('0');
            $table->timestamps();
            $table->primary(['user_id', 'friend_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('friend_users');
    }
}

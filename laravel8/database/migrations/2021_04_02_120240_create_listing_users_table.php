<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
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
            $table->timestamps();
            $table->primary(['listing_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listing_users');
    }
}

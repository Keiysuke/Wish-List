<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWebsitesTable extends Migration
{
    public function up()
    {
        Schema::create('user_websites', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('website_id');
            $table->integer('ordered')->default('0');
            $table->timestamps();
            $table->primary(['user_id', 'website_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_websites');
    }
}

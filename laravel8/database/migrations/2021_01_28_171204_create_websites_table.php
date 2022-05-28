<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsitesTable extends Migration
{
    public function up()
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', 50)->unique();
            $table->longText('url');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('websites');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVgDevelopersTable extends Migration
{
    public function up()
    {
        Schema::create('vg_developers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', 200)->unique();
            $table->longText('description')->nullable();
            $table->smallInteger('year_created')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vg_developers');
    }
}

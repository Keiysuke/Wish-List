<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelStepsTable extends Migration
{
    public function up()
    {
        Schema::create('travel_steps', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('travel_journey_id');
            $table->foreign('travel_journey_id')
                ->references('id')
                ->on('travel_journeys')
                ->onDelete('cascade');
            $table->unsignedInteger('city_id');
            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('travel_steps');
    }
};

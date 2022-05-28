<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoSellingOffersTable extends Migration
{
    public function up()
    {
        Schema::create('histo_selling_offers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('selling_id');
            $table->foreign('selling_id')
                ->references('id')
                ->on('sellings')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('price', $precision = 10, $scale = 2);
            $table->date('day')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('histo_selling_offers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVgSupportsTable extends Migration
{
    public function up()
    {
        Schema::create('vg_supports', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('product_id')->nullable();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->longText('label');
            $table->string('alias', 10)->nullable();
            $table->date('date_released');
            $table->integer('price');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('vg_supports');
    }
}

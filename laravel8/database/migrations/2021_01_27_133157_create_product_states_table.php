<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStatesTable extends Migration
{
    public function up()
    {
        Schema::create('product_states', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyIncrements('id');
            $table->string('label', 45)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_states');
    }
}

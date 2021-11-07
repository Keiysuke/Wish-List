<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->longText('label');
            $table->longText('description')->nullable();
            $table->integer('limited_edition')->nullable();
            $table->decimal('real_cost', $precision = 10, $scale = 2);
            $table->timestamps();
            //$table->softDeletes();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellingsTable extends Migration
{
    public function up()
    {
        Schema::create('sellings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // keep type compatible with users.id (unsigned INT)
            $table->unsignedInteger('user_id')->default(1);
            $table->unsignedInteger('product_id');
            $table->unsignedTinyInteger('product_state_id');
            $table->unsignedInteger('purchase_id');
            $table->unsignedInteger('website_id');
            $table->unsignedTinyInteger('sell_state_id');
            $table->decimal('price', $precision = 10, $scale = 2);
            $table->decimal('confirmed_price', $precision = 10, $scale = 2)->nullable();
            $table->decimal('shipping_fees', $precision = 10, $scale = 2)->nullable();
            $table->decimal('shipping_fees_payed', $precision = 10, $scale = 2)->nullable();
            $table->integer('nb_views')->nullable();
            $table->date('date_begin')->nullable();
            $table->date('date_sold')->nullable();
            $table->date('date_send')->nullable();
            $table->tinyInteger('box');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sellings');
    }
}

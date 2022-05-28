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
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedTinyInteger('product_state_id');
            $table->foreign('product_state_id')
                ->references('id')
                ->on('product_states')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('purchase_id');
            $table->foreign('purchase_id')
                ->references('id')
                ->on('purchases')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('website_id');
            $table->foreign('website_id')
                ->references('id')
                ->on('websites')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedTinyInteger('sell_state_id');
            $table->foreign('sell_state_id')
                ->references('id')
                ->on('sell_states')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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

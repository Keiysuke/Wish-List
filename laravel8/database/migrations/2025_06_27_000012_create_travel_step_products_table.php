<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelStepProductsTable extends Migration
{
    public function up()
    {
        Schema::create('travel_step_products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('travel_step_id');
            $table->foreign('travel_step_id')
                ->references('id')
                ->on('travel_steps')
                ->onDelete('cascade');
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->unsignedInteger('purchase_id')->nullable();
            $table->foreign('purchase_id')
                ->references('id')
                ->on('purchases')
                ->onDelete('set null');
            $table->unsignedInteger('group_buy_id')->nullable();
            $table->foreign('group_buy_id')
                ->references('id')
                ->on('group_buys')
                ->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('travel_step_products');
    }
};

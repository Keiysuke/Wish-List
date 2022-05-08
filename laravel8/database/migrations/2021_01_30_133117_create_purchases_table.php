<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
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
            $table->unsignedInteger('website_id');
            $table->foreign('website_id')
                ->references('id')
                ->on('websites')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('cost', $precision = 10, $scale = 2);
            $table->date('date');
            $table->decimal('customs', $precision = 10, $scale = 2)->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}

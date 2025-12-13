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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedInteger('product_id');
            $table->unsignedTinyInteger('product_state_id');
            $table->unsignedInteger('website_id');
            $table->decimal('cost', $precision = 10, $scale = 2);
            $table->date('date');
            $table->date('date_received')->nullable();
            $table->decimal('customs', $precision = 10, $scale = 2)->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}

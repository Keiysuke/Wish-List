<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupBuyPurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('group_buy_purchases', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('group_buy_id');
            $table->foreign('group_buy_id')
                ->references('id')
                ->on('group_buys')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('purchase_id');
            $table->foreign('purchase_id')
                ->references('id')
                ->on('purchases')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->primary(['group_buy_id', 'purchase_id']);
        });
    }

    public function down(){
        Schema::dropIfExists('group_buy_purchases');
    }
}

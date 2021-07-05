<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupBuysTable extends Migration
{
    public function up(){
        Schema::create('group_buys', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->longText('label')->nullable();
            $table->date('date');
            $table->decimal('global_cost', $precision = 10, $scale = 2);
            $table->decimal('shipping_fees', $precision = 10, $scale = 2);
            $table->tinyInteger('archived')->default(0);
            $table->timestamps();
        });
    }
    
    public function down(){
        Schema::dropIfExists('group_buys');
    }
}

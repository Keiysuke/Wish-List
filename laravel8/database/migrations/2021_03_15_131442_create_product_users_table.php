<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductUsersTable extends Migration
{
    public function up()
    {
        Schema::create('product_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('product_id');
            $table->tinyInteger('archive')->default(0);
            $table->timestamps();
            $table->primary(['user_id', 'product_id']);
        });
    }
    
    public function down(){
        Schema::dropIfExists('product_users');
    }
}

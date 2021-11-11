<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTagsTable extends Migration
{
    public function up()
    {
        Schema::create('product_tags', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('tag_id');
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
            $table->primary(['product_id', 'tag_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('product_tags');
    }
}

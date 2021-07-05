<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingProductsTable extends Migration
{
    public function up()
    {
        Schema::create('listing_products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('listing_id');
            $table->foreign('listing_id')
                ->references('id')
                ->on('listings')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->tinyInteger('nb')->default(1);
            $table->timestamps();
            $table->primary(['listing_id', 'product_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('listing_products');
    }
}

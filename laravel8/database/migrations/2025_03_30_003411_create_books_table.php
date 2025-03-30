<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->unsignedInteger('product_id')->nullable();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedInteger('book_publisher_id');
            $table->foreign('book_publisher_id')
                ->references('id')
                ->on('book_publishers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('page_count')->default(0);
            $table->string('format', 50)->default('Poche');
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('width', 5, 2)->nullable();
            $table->decimal('thickness', 5, 2)->nullable();
            $table->date('publication_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
}

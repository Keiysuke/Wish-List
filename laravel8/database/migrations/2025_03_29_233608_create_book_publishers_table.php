<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookPublishersTable extends Migration
{
    public function up()
    {
        Schema::create('book_publishers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', 200)->unique();
            $table->longText('description')->nullable();
            $table->smallInteger('founded_year')->nullable();
            $table->string('country', 100)->default('Inconnu');
            $table->unsignedInteger('website_id');
            $table->foreign('website_id')
                ->references('id')
                ->on('websites')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->tinyInteger('active')->default('1');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('book_publishers');
    }
}

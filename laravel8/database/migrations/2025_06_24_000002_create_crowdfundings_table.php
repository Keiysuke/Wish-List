<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrowdfundingsTable extends Migration {
    public function up(): void
    {
        Schema::create('crowdfundings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('website_id');
            $table->string('project_name')->nullable();
            $table->string('project_url')->nullable();
            $table->decimal('goal_amount', 15, 2)->nullable();
            $table->decimal('current_amount', 15, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('shipping_date')->nullable();
            $table->string('state_id')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('crowdfunding_states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crowdfundings');
    }
}

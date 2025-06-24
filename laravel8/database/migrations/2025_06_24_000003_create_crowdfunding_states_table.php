<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrowdfundingStatesTable extends Migration
{
    public function up(): void
    {
        Schema::create('crowdfunding_states', function (Blueprint $table) {
            $table->id();
            $table->string('label', 50)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crowdfunding_states');
    }
}

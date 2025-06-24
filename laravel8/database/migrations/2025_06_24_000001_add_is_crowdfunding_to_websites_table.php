<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsCrowdfundingToWebsitesTable extends Migration 
{
    public function up(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->boolean('is_crowdfunding')
                ->default(false)
                ->after('url')
                ->comment('Indique si le site est une plateforme de crowdfunding (Kickstarter, etc.)');
        });
    }

    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn('is_crowdfunding');
        });
    }
}

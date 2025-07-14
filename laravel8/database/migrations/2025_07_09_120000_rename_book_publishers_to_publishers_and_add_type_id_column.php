<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class RenameBookPublishersToPublishersAndAddTypeIdColumn extends Migration
{
    public function up()
    {
        // S'assurer que le type "book" existe dans publisher_types
        if (!DB::table('publisher_types')->where('id', 1)->exists()) {
            Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\PublisherTypesTableSeeder']);
        }
        // Renommer la table
        Schema::rename('book_publishers', 'publishers');
        // Ajouter la colonne type_id et la contrainte
        Schema::table('publishers', function (Blueprint $table) {
            $table->unsignedInteger('type_id')->default(1)->after('id');
            $table->foreign('type_id')->references('id')->on('publisher_types')->onDelete('restrict');
        });
    }

    public function down()
    {
        // Supprimer la contrainte et la colonne
        Schema::table('publishers', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropColumn('type_id');
        });
        // Renommer la table à l'envers
        Schema::rename('publishers', 'book_publishers');
    }
}

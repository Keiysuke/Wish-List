<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable FK checks temporarily to avoid circular dependency issues during FK creation
        DB::statement('SET foreign_key_checks=0');

        try {
            // Add all foreign keys in a single migration to avoid ordering issues
            Schema::table('purchases', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_state_id')->references('id')->on('product_states')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('sellings', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_state_id')->references('id')->on('product_states')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('sell_state_id')->references('id')->on('sell_states')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('product_users', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('listings', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('listing_users', function (Blueprint $table) {
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('group_buys', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('user_websites', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('website_id')->references('id')->on('websites')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('friend_users', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('friend_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('listing_messages', function (Blueprint $table) {
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('answer_to_id')->references('id')->on('listing_messages')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('list_msg_reactions', function (Blueprint $table) {
            $table->foreign('list_msg_id')->references('id')->on('listing_messages')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('emoji_id')->references('id')->on('emojis')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('travel_journeys', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'created_by')) {
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            }
        });

        Schema::table('video_games', function (Blueprint $table) {
            if (Schema::hasColumn('video_games', 'created_by')) {
                $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            }
        });

        } finally {
            // Re-enable FK checks after all FK creation
            DB::statement('SET foreign_key_checks=1');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['product_state_id']);
            $table->dropForeign(['website_id']);
        });

        Schema::table('sellings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['product_state_id']);
            $table->dropForeign(['purchase_id']);
            $table->dropForeign(['website_id']);
            $table->dropForeign(['sell_state_id']);
        });

        Schema::table('product_users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::table('listings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('listing_users', function (Blueprint $table) {
            $table->dropForeign(['listing_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('group_buys', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('user_websites', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['website_id']);
        });

        Schema::table('friend_users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['friend_id']);
        });

        Schema::table('listing_messages', function (Blueprint $table) {
            $table->dropForeign(['listing_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['answer_to_id']);
        });

        Schema::table('list_msg_reactions', function (Blueprint $table) {
            $table->dropForeign(['list_msg_id']);
            $table->dropForeign(['emoji_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('travel_journeys', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'created_by')) {
                $table->dropForeign(['created_by']);
            }
        });

        Schema::table('video_games', function (Blueprint $table) {
            if (Schema::hasColumn('video_games', 'created_by')) {
                $table->dropForeign(['created_by']);
            }
        });
    }
};

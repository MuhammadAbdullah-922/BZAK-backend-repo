<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * GUEST CHECKOUT FIX
 *
 * Without this migration, OrderController@store's optional($user)->id
 * (null for guests) will still fail at the database level with a
 * "Column 'user_id' cannot be null" SQL error, even after the route and
 * controller changes. Both tables need user_id to accept NULL.
 *
 * Requires doctrine/dbal: composer require doctrine/dbal
 * (Laravel needs it to run column ->change() on existing columns.)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {

            if (Schema::hasColumn('users', 'name')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('name');
                });
            }

            Schema::table('users', function (Blueprint $table) {
                $table->string('first_name');
                $table->string('last_name');
                $table->string('currency_display')->nullable();
                $table->string('language_spoken')->nullable();
                $table->string('phone')->nullable();
                $table->integer('status')->default('1');
                $table->string('description')->nullable();
                $table->boolean('marketing_consent')->default(false);
                $table->string('google_id')->nullable();
                $table->integer('isAdmin')->nullable();
                $table->string('timezone')->nullable();
            });

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('first_name');
                $table->dropColumn('last_name');
                $table->dropColumn('currency_display');
                $table->dropColumn('language_spoken');
                $table->dropColumn('phone');
                $table->dropColumn('status',);
                $table->dropColumn('description');
                $table->dropColumn('marketing_consent');
                $table->dropColumn('google_id');
                $table->dropColumn('isAdmin',);
                $table->dropColumn('timezone');
            });
        }
    }
};

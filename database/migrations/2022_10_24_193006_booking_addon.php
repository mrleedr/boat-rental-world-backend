<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('booking_addon')) {
            Schema::create('booking_addon', function (Blueprint $table) {
                $table->id('booking_addon_id');
                $table->integer('trip_addon_id');
                $table->integer('quantity')->default(1);
                $table->string('other_request');
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
        Schema::dropIfExists('booking_addon');
    }
};

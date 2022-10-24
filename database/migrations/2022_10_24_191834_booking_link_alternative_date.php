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
        if (!Schema::hasTable('booking_link_booking_alternative_date')) {
            Schema::create('booking_link_booking_alternative_date', function (Blueprint $table) {
                $table->integer('booking_id');
                $table->integer('booking_alternative_date_id');
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
        Schema::dropIfExists('booking_link_booking_alternative_date');
    }
};

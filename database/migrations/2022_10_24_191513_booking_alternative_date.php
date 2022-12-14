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
        if (!Schema::hasTable('booking_alternative_date')) {
            Schema::create('booking_alternative_date', function (Blueprint $table) {
                $table->id('booking_alternative_date_id');
                $table->date('preferred_date');
                $table->date('return_date');
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
        Schema::dropIfExists('booking_alternative_date');
    }
};

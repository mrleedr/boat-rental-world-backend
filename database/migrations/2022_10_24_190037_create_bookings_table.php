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
        if (!Schema::hasTable('booking')) {
            Schema::create('booking', function (Blueprint $table) {
                $table->id('booking_id');
                $table->integer('operator_status_id');
                $table->string('duration_hour')->nullable();
                $table->string('duration_minutes')->nullable();
                $table->string('overnight')->nullable();
                $table->string('preferred_date')->date();
                $table->string('return_date')->date();
                $table->time('pick_up_time')->time();
                $table->time('drop_off_time')->time();
                $table->integer('no_of_guest');
                $table->text('other_request')->nullable();
                $table->integer('booking_status_id')->default(1);
                $table->timestamps();
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
        Schema::dropIfExists('booking');
    }
};

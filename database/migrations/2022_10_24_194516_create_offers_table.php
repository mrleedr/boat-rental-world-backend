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
        if (!Schema::hasTable('offer')) {
            Schema::create('offer', function (Blueprint $table) {
                $table->id('offer_id');
                $table->integer('operator_status_id');
                $table->integer('duration_hour');
                $table->integer('duration_minutes');
                $table->integer('overnight');
                $table->date('preferred_date');
                $table->date('return_date');
                $table->time('pick_up_time');
                $table->time('drop_off_time');
                $table->integer('no_of_guest');
                $table->decimal('offer_amount_owner_currency');
                $table->decimal('tour_amount_renter_currency');
                $table->decimal('addon_amount_renter_currency');
                $table->decimal('service_fee_renters_currency');
                $table->string('offer_additional_message');
                $table->integer('offer_status_id')->default(1);
                $table->date('expiration_date');
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
        Schema::dropIfExists('offer');
    }
};

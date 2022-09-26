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
        if (!Schema::hasTable('trip_link_location')) {
            Schema::create('pricing', function (Blueprint $table) {
                $table->integer('pricing_id');
                $table->string('currency');
                $table->string('price_type');
                $table->decimal('price_per_day');
                $table->integer('per_day_minimum');
                $table->decimal('price_per_week');
                $table->decimal('price_per_hour');
                $table->integer('per_hour_minimum');
                $table->integer('per_night_minimum');
                $table->decimal('price_per_night');
                $table->integer('cancellation_refund_rate');
                $table->integer('cancellation_allowed_days');
                $table->text('rental_terms');
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
        Schema::dropIfExists('pricing');
    }
};

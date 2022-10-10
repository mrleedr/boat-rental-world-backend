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
        if (!Schema::hasTable('pricing')) {
            Schema::create('pricing', function (Blueprint $table) {
                $table->id('pricing_id');
                $table->string('currency')->nullable();
                $table->decimal('price_per_day')->nullable();
                $table->integer('per_day_minimum')->nullable();
                $table->decimal('price_per_week')->nullable();
                $table->decimal('price_per_hour')->nullable();
                $table->integer('per_hour_minimum')->nullable();
                $table->decimal('price_per_night')->nullable();
                $table->integer('per_night_minimum')->nullable();
                $table->decimal('security_allowance')->nullable();
                $table->decimal('price_per_multiple_days')->nullable();
                $table->integer('per_multiple_days_minimum')->nullable();
                $table->decimal('price_per_multiple_hours')->nullable();
                $table->integer('per_multiple_hours_minimum')->nullable();
                $table->decimal('price_per_person')->nullable();
                $table->integer('per_person_minimum')->nullable();
                $table->integer('per_person_charge_type')->nullable();
                $table->integer('cancellation_refund_rate')->nullable();
                $table->integer('cancellation_allowed_days')->nullable();
                $table->text('rental_terms')->nullable();
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

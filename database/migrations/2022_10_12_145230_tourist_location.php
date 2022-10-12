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
       
        if (!Schema::hasTable('tourist_location')) {
            Schema::create('tourist_location', function (Blueprint $table) {
                $table->id('tourist_location_id');
                $table->string('city');
                $table->string('state');
                $table->string('country');
                $table->string('address');
                $table->string('latitude');
                $table->string('longitude');
                $table->string('slug')->unique();
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
        Schema::dropIfExists('tourist_location');
    }
};

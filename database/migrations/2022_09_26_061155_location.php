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
        if (!Schema::hasTable('location')) {
            Schema::create('location', function (Blueprint $table) {
                $table->id('location_id');
                $table->string('city');
                $table->string('state');
                $table->string('country');
                $table->string('zip');
                $table->string('address');
                $table->string('latitude');
                $table->string('longitude');
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
        Schema::dropIfExists('location');
    }
};

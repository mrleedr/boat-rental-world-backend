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
        if (!Schema::hasTable('vessel')) {
            Schema::create('vessel', function (Blueprint $table) {
                $table->id('vessel_id');
                $table->string('make_model')->nullable();
                $table->string('length')->nullable();
                $table->string('year')->nullable();
                $table->integer('capacity')->nullable();
                $table->string('number_of_engines')->nullable();
                $table->string('engine_horsepower')->nullable();
                $table->string('engine_brand')->nullable();
                $table->string('engine_mode')->nullable();
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
        Schema::dropIfExists('vessel');
    }
};

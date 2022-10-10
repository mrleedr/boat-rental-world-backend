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
        if (!Schema::hasTable('trip_link_trip_category')) {
            Schema::create('trip_link_trip_category', function (Blueprint $table) {
                $table->integer('trip_id');
                $table->integer('trip_category_id');
                $table->boolean('primary')->default(false);
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
        Schema::dropIfExists('trip_link_trip_category');
    }
};

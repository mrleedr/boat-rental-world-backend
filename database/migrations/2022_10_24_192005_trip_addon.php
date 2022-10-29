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
        if (!Schema::hasTable('trip_addon')) {
            Schema::create('trip_addon', function (Blueprint $table) {
                $table->id('trip_addon_id');
                $table->string('description');
                $table->decimal('price');
                $table->string('currency');
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
        Schema::dropIfExists('trip_addon');
    }
};

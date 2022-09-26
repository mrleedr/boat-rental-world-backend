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
        if (!Schema::hasTable('trip')) {
            Schema::create('trip', function (Blueprint $table) {
                $table->id('trip_id');
                $table->string('head_line');
                $table->text('description');
                $table->integer('trip_status',)->default('1');
                $table->integer('operator_status');
                $table->timestamp('created_at');
                $table->timestamp('updated_at');
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
        Schema::dropIfExists('trip');
    }
};
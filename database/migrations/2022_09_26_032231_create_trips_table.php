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
                $table->string('head_line')->nullable();
                $table->text('description')->nullable();
                $table->integer('trip_status_id',)->default('1');
                $table->integer('operator_status_id')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
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

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
        if (!Schema::hasTable('client_review')) {
            Schema::create('client_review', function (Blueprint $table) {
                $table->id('client_review_id');
                $table->integer('client_user_id');
                $table->integer('star');
                $table->string('comments');
                $table->boolean('show')->default(true);
                $table->date('comment_date');
              
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
        Schema::dropIfExists('client_review');
    }
};

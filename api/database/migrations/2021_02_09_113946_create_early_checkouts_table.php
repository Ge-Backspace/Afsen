<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarlyCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('early_checkouts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('checkin_id')->unsigned();
            $table->string('reason');
            $table->timestamps();

            $table->foreign('checkin_id')->references('id')->on('checkins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('early_checkouts');
    }
}

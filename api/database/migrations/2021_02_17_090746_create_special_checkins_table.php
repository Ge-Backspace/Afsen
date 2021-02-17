<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialCheckinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_checkins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('checkin_id')->unsigned();
            $table->string('reason');
            $table->integer('type');
            $table->integer('file_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('checkin_id')->references('id')->on('checkins');
            $table->foreign('file_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('special_checkins');
    }
}

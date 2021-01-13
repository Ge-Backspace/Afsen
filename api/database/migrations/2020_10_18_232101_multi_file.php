<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MultiFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multi_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_file')->unsigned();
            $table->integer('id_parent');
            $table->string('type', 4);
            $table->timestamps();

            $table->foreign('id_file')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('multi_files');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee1_id')->unsigned();
            $table->integer('employee2_id')->unsigned();
            $table->integer('shift_employee1_id')->unsigned();
            $table->integer('shift_employee2_id')->unsigned();
            $table->integer('status_id')->default(0);
            $table->string('reason');
            $table->integer('file_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('employee1_id')->references('id')->on('employees');
            $table->foreign('employee2_id')->references('id')->on('employees');
            $table->foreign('shift_employee1_id')->references('id')->on('shift_employees');
            $table->foreign('shift_employee2_id')->references('id')->on('shift_employees');
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
        Schema::dropIfExists('shift_permissions');
    }
}

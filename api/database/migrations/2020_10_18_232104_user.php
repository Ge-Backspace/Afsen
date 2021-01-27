<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('company_id')->unsigned();
            $table->integer('propic_id')->unsigned()->nullable();
            $table->boolean('admin')->default(false);
            $table->boolean('aktif')->default(false);
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('propic_id')->references('id')->on('files')->onDelete('CASCADE');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

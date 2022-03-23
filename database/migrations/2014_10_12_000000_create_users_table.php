<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
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
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('loginotp');
            $table->string('password');
            $table->string('lang')->nullable();
            $table->string('project')->nullable();
            $table->string('role')->nullable();
            $table->string('booth')->nullable();
            $table->longtext('welcometext')->nullable();
            $table->string('company')->nullable();
            $table->string('position')->nullable();
            $table->string('suggestion')->nullable();
            $table->string('imageurl')->nullable();
            $table->rememberToken();
            $table->timestamps();
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

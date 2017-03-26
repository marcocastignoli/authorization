<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->string('email', 255);
            $table->string('password', 255);
            $table->integer('auth');
        });
    }

    public function down()
    {
        Schema::drop('users');
    }
}

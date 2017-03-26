<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizationsTable extends Migration
{
    public function up()
    {
        Schema::create('authorizations', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('auth');
            $table->string('object', 255);
            $table->string('field', 255);
            $table->string('method', 255);
            $table->string('entity', 255);
        });
    }

    public function down()
    {
        Schema::drop('authorizations');
    }
}

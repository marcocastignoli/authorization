<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizationsTable extends Migration
{
    public function up()
    {
        Schema::create('authorizations', function(Blueprint $t)
        {
            $t->increments('id')->unsigned();
            $t->text('slug', 255);
            $t->text('name', 255);
            $t->text('description', 255);
            $t->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('authorizations');
    }
}

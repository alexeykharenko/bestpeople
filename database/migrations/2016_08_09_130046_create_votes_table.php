<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_who')->unsigned();
            $table->foreign('id_who')->references('id')->on('users');
            $table->integer('id_target')->unsigned();
            $table->foreign('id_target')->references('id')->on('users');
            $table->unique(['id_who', 'id_target']);
            $table->enum('vote', ['plus', 'minus']);
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
        Schema::drop('votes');
    }
}

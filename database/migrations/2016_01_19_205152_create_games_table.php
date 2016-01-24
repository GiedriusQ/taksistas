<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->unsigned()->index();
            $table->foreign('owner_id')->references('id')->on('sessions');
            $table->integer('opponent_id')->unsigned()->index()->nullable();
            $table->foreign('opponent_id')->references('id')->on('sessions');
            $table->string('title', 50);
            $table->boolean('owner_turn')->default(false);
            $table->boolean('end')->default(false);
            $table->json('board');
            $table->timestamp('started_at');
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
        Schema::drop('games');
    }
}

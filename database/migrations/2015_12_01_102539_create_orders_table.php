<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('driver_id')->index()->unsigned()->nullable();
            $table->foreign('driver_id')->references('id')->on('users');
            $table->integer('dispatcher_id')->index()->unsigned();
            $table->foreign('dispatcher_id')->references('id')->on('users');
            $table->string('address', 150);
            $table->decimal('lat', 11, 8);
            $table->decimal('lng', 11, 8);
            $table->decimal('destination_lat', 11, 8)->default(0);
            $table->decimal('destination_lng', 11, 8)->default(0);
            $table->tinyInteger('status')->unsigned()->default(0);
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
        Schema::drop('orders');
    }
}

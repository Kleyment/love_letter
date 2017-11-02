<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idpartie');
            $table->integer('nbtour'); //1-16 ?
            $table->integer('idjoueur');
            $table->integer('typeaction'); //1-?
            //Optionnels
            $table->integer('idvictime'); //1-4
            $table->integer('typecarte'); //1-8
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
        Schema::dropIfExists('tours');
    }
}

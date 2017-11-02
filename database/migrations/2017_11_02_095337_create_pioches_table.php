<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePiochesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pioches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idpartie');
            $table->integer('position'); //1-16 (1 signifie le haut de la pioche)
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
        Schema::dropIfExists('pioches');
    }
}

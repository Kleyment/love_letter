<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaussesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('defausses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idpartie');
            $table->integer('position'); //1-16 (1 signifie haut de la défausse)
            $table->integer('typecarte');  //1-8 le type de la carte défaussé
            $table->integer('idjoueur'); //L'id du joueur qui a défaussé sa carte
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('defausses');
    }
}

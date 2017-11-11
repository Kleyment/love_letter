<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idpartie');
            $table->integer('carteg1');
            $table->integer('carted1');
            $table->integer('carteg2');
            $table->integer('carted2');
            $table->integer('carteg3');
            $table->integer('carted3');
            $table->integer('carteg4');
            $table->integer('carted4');
            $table->integer('defausse');
            $table->integer('nbdefausse');
            $table->integer('nbpioche');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etats');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->increments('idpartie');
            $table->string('nomj1');
            $table->string('nomj2');
            $table->string('nomj3');
            $table->string('nomj4');
            $table->integer('idj1');
            $table->integer('idj2');
            $table->integer('idj3');
            $table->integer('idj4');
            $table->integer('nbjoueurs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parties');
    }
}

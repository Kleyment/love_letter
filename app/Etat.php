<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etat extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'idpartie', 'carteg1', 'carted1', 'carteg2', 'carted2', 'carteg3', 'carted3', 'carteg4', 'carted4', 'defausse',
        'nbdefausse', 'nbpioche'
    ];

    public static function creerEtatBidon($idpartie) {
      Etat::create(['idpartie' => $idpartie, 'carteg1' => 1, 'carted1' => 8, 'carteg2' => -1, 'carted2' => -1, 'carteg3' => -1, 'carted3' => -1, 'carteg4' => -1, 'carted4' => -1, 'defausse' => 2,
      'nbdefausse' => 1, 'nbpioche' => 13]);
    }


}

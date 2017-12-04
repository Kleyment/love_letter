<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pioche extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'idpartie', 'position', 'typecarte'
    ];

    public static function initialiserPioche($idpartie) {
      for ($i=1;$i<=5;$i++) {
          Pioche::create(["idpartie" => $idpartie, "position" => 0, "typecarte" => 1]);
      }
      Pioche::create(["idpartie" => $idpartie, "position" => 0, "typecarte" => 2]);
      Pioche::create(["idpartie" => $idpartie, "position" => 0, "typecarte" => 2]);

      Pioche::create(["idpartie" => $idpartie, "position" => 0, "typecarte" => 3]);
      Pioche::create(["idpartie" => $idpartie, "position" => 0, "typecarte" => 3]);

      Pioche::create(["idpartie" => $idpartie, "position" => 0, "typecarte" => 4]);
      Pioche::create(["idpartie" => $idpartie, "position" => 0, "typecarte" => 4]);

      Pioche::create(["idpartie" => $idpartie, "position" => 0, "typecarte" => 5]);
      Pioche::create(["idpartie" => $idpartie, "position" => 0, "typecarte" => 5]);

      Pioche::create(["idpartie" => $idpartie, "position" => 0, "typecarte" => 6]);

      Pioche::create(["idpartie" => $idpartie, "position" => 0, "typecarte" => 7]);

      Pioche::create(["idpartie" => $idpartie, "position" => 0, "typecarte" => 8]);

      //Melange de la pioche
      for($i=1;$i<=16;$i++){
        $cartepioche=Pioche::where('idpartie', $idpartie)->where('position', 0)->get()->random();
        $cartepioche->position=$i;
        $cartepioche->save();
      }
    }



}

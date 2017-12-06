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

    //Au début faire tirerCarte($id,-1)
    public static function tirerCarte($idpartie,$idjoueur) {
      $carte=Pioche::where('idpartie', $idpartie)->where('position', 1)->get()->first();
      $typecarte=$carte->typecarte;

      //Suppression de la carte de la Pioche
      $carte->delete();

      //Décalage de toutes les positions
      $size=Pioche::where('idpartie',$idpartie)->get()->count();
      for($i=0;$i<$size;$i++){
        $carte=Pioche::where('idpartie',$idpartie)->get()[$i];
        $carte->position=$carte->position-1;
        $carte->save();
      }

      //Si l'idjoueur n'est pas spécifié la carte va directement dans la défausse
      if ($idjoueur == -1) {
        Defausse::defausserCarte($idpartie,$typecarte,-1);
      } else {
        //On ajoute la carte à la main du joueur
        Main::tirerCarte($idpartie,$idjoueur,$typecarte);
      }
    }



}

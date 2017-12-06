<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Main extends Model
{
    public $timestamps = false;

    protected $attributes = array(
      'carteg' => -1, 'carted' => -1
    );

    protected $fillable = [
        'idpartie', 'idjoueur', 'carteg', 'carted'
    ];

    public static function initialiserMains($idpartie,$nbjoueurs) {
      $idj1=Partie::getPartie($idpartie)->idj1;
      $idj2=Partie::getPartie($idpartie)->idj2;

      Main::create(["idpartie" => $idpartie, "idjoueur" => $idj1]);
      Main::create(["idpartie" => $idpartie, "idjoueur" => $idj2]);

      if ($nbjoueurs >= 3) {
        $idj3=Partie::getPartie($idpartie)->idj3;
        Main::create(["idpartie" => $idpartie, "idjoueur" => $idj3]);
      }

      if ($nbjoueurs == 4) {
        $idj4=Partie::getPartie($idpartie)->idj4;
        Main::create(["idpartie" => $idpartie, "idjoueur" => $idj4]);
      }
    }

    /*public static function getMain($idpartie, $idjoueur) {
      return Main::where('idpartie',$idpartie)->where('idjoueur',$idjoueur)->get()->first();
    }*/

    public static function tirerCarte($idpartie,$idjoueur,$typecarte) {
      $main=Main::where('idpartie',$idpartie)->where('idjoueur',$idjoueur)->get()->first();
      if ($main->carteg == -1) {
        $main->carteg=$typecarte;
        $main->save();
      } else if ($main->carted == -1) {
        $main->carted=$typecarte;
        $main->save();
      }
    }

    public static function defausserCarte($idpartie,$idjoueur,$typecarte) {
      $main=Main::where('idpartie',$idpartie)->where('idjoueur',$idjoueur)->get()->first();
      if ($main->carteg == $typecarte) {
        $main->carteg=$main->carted;
        $main->carted=-1;
      } else if ($main->carted == $typecarte) {
        $main->carted=-1;
      }
      $main->save();
    }
}

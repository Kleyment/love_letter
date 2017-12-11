<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Partie;

class Tour extends Model {
    public $timestamps = false;

    protected $fillable = [
        'idpartie', 'nbtour', 'idjoueur', 'typeaction', 'idvictime', 'typecarte'
    ];


    public static function nouveauTour($idpartie) {
      $tour=Tour::where('nbtour',\DB::table('tours')->max('nbtour'))->get()->first();
      if ($tour) {
        return $tour->nbtour+1;
      } else {
        return 1;
      }
    }

    public static function quiPeutFaireQuoi($idpartie) {
      $idpiocheur=self::quiPeutPiocher($idpartie);
      if ($idpiocheur != -1) {
        return "C'est au joueur ".$idpiocheur." de piocher";
      }
      $iddefausseur=self::quiPeutDefausser($idpartie);
      if ($iddefausseur != -1) {
        return "C'est au joueur ".$iddefausseur." de défausser";
      }
    }

    //typeaction 1 piocher / 2 défausser

    public static function quiPeutPiocher($idpartie) {
      $partie=Partie::getPartie($idpartie);
      $tour=Tour::where('nbtour',\DB::table('tours')->max('nbtour'))->get()->first();
      if ($tour) {
        if ($tour->idjoueur == $partie->idj1) {
          if ($tour->typeaction == 2) {
            return 2;
          } else {
            return -1;
          }
        } else {
          if ($tour->typeaction == 2) {
            return 1;
          } else {
            return -1;
          }
        }
      } else {
        return 1;
      }
    }

    public static function quiPeutDefausser() {
      $tour=Tour::where('nbtour',\DB::table('tours')->max('nbtour'))->get()->first();
      if ($tour) {
        if ($tour->idjoueur == 1) {
          if ($tour->typeaction == 1) {
            return 1;
          } else {
            return -1;
          }
        } else {
          if ($tour->typeaction == 1) {
            return 2;
          } else {
            return -1;
          }
        }
      } else {
        return -1;
      }
    }
}

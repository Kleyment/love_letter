<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Defausse extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'idpartie', 'position', 'typecarte', 'idjoueur'
    ];


    public static function defausserCarte($idpartie,$typecarte,$idjoueur) {

      //Décalage de toutes les positions
      $size=Defausse::where('idpartie',$idpartie)->get()->count();
      for($i=0;$i<$size;$i++){
        $carte=Defausse::where('idpartie',$idpartie)->get()[$i];
        $carte->position=$carte->position+1;
        $carte->save();
      }

      Defausse::create(['idpartie' => $idpartie, 'position' => 1, 'typecarte' => $typecarte, 'idjoueur' => $idjoueur]);

      //Si l'idjoueur n'est pas spécifié la carte va directement dans la défausse
      if ($idjoueur != -1) {
        Main::defausserCarte($idpartie,$idjoueur,$typecarte);
      }
    }

    public static function nbDefausse($idpartie) {
      return Defausse::where('idpartie',$idpartie)->get()->count();
    }

    public static function cardOntTheTop($idpartie) {
      if (Defausse::nbDefausse($idpartie) > 0) {
        return Defausse::where('idpartie',$idpartie)->where('position',1)->get()->first()->typecarte;
      } else {
        return -1;
      }
    }


}

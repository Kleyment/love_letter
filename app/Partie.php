<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partie extends Model
{
    public $timestamps = false;

    public static $idpartie=0;

    protected $attributes = array(
      'nomj2' => '', 'nomj3' => '', 'nomj4' => ''
    );

    protected $fillable = [
        'idpartie', 'nomj1', 'nomj2', 'nomj3', 'nomj4', 'nbjoueurs'
    ];

    //Dès qu'un utilisateur créé une partie, il la rejoint
    public static function creerPartie($pseudo,$nbjoueurs) {
      //String à hasher, il contient un sel, le temps actuel et un nombre aléatoire
      self::$idpartie=self::$idpartie+1;
      Partie::create(['idpartie' => self::$idpartie, 'nomj1' => $pseudo, 'nbjoueurs' => $nbjoueurs]);
    }

    public static function getPartie($idpartie) {
      return Partie::where('idpartie', $idpartie)->get()->first();
    }

    public function rejoindrePartie($pseudo) {
      //Un joueur ne pas rejoindre plusieurs fois une partie
      if ($this->nomj1 == $pseudo || $this->nomj2 == $pseudo || $this->nomj3 == $pseudo || $this->nomj4 == $pseudo) {
        return false;
      }

      if ($this->nbjoueurs == 2) {
        if (empty($this->nomj2)) {
          $this->nomj2=$pseudo;
        } else {
          return false;
        }
      } else if ($this->nbjoueurs == 3) {
        if empty($this->nomj2) {
          $this->nomj2=$pseudo;
        } else {
          if empty($this->nomj3) {
            $this->nomj3=$pseudo;
          } else {
            return false;
          }
        }
      } else {
        if empty($this->nomj2) {
          $this->nomj2=$pseudo;
        } else {
          if empty($this->nomj3) {
            $this->nomj3=$pseudo;
          } else {
            if empty($this->nomj4) {
              $this->nomj4=$pseudo;
            } else {
              return false;
            }
          }
        }
      }
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partie extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'idpartie';

    protected $attributes = array(
      'nomj2' => '', 'nomj3' => '', 'nomj4' => ''
    );

    protected $fillable = [
        'idpartie', 'nomj1', 'nomj2', 'nomj3', 'nomj4', 'nbjoueurs'
    ];

    //Dès qu'un utilisateur créé une partie, il la rejoint
    public static function creerPartie($pseudo,$nbjoueurs) {
      $partie=Partie::create(['nomj1' => $pseudo, 'nbjoueurs' => $nbjoueurs]);
      $idpartie=$partie->idpartie;
      Pioche::initialiserPioche($idpartie);
      return $idpartie;
    }

    public static function getPartie($idpartie) {
      return Partie::where('idpartie', $idpartie)->get()->first();
    }

    public static function toutesLesParties() {
      return Partie::all();
    }

    public function rejoindrePartie($pseudo) {

      //Un joueur ne pas rejoindre plusieurs fois une partie
      if ($this->nomj1 == $pseudo || $this->nomj2 == $pseudo || $this->nomj3 == $pseudo || $this->nomj4 == $pseudo) {
        return false;
      }

      if ($this->nbjoueurs == 2) {
        if (empty($this->nomj2)) {
          $this->nomj2=$pseudo;
          $this->save();
          return true;
        } else {
          return false;
        }
      } else if ($this->nbjoueurs == 3) {
        if (empty($this->nomj2)) {
          $this->nomj2=$pseudo;
          $this->save();
          return true;
        } else {
          if (empty($this->nomj3)) {
            $this->nomj3=$pseudo;
            $this->save();
            return true;
          } else {
            return false;
          }
        }
      } else {
        if (empty($this->nomj2)) {
          $this->nomj2=$pseudo;
          $this->save();
          return true;
        } else {
          if (empty($this->nomj3)) {
            $this->nomj3=$pseudo;
            $this->save();
            return true;
          } else {
            if (empty($this->nomj4)) {
              $this->nomj4=$pseudo;
              $this->save();
              return true;
            } else {
              return false;
            }
          }
        }
      }
    }
}

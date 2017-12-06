<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partie extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'idpartie';

    protected $attributes = array(
      'nomj2' => '', 'nomj3' => '', 'nomj4' => '', 'idj2' => -1, 'idj3' => -1, 'idj4' => -1
    );

    protected $fillable = [
        'idpartie', 'nomj1', 'nomj2', 'nomj3', 'nomj4', 'nbjoueurs', 'idj1', 'idj2', 'idj3', 'idj4'
    ];

    //Dès qu'un utilisateur créé une partie, il la rejoint
    public static function creerPartie($pseudo,$nbjoueurs) {
      $idj1=Utilisateur::getUtilisateurFromPseudo($pseudo)->id;
      $partie=Partie::create(['nomj1' => $pseudo, 'nbjoueurs' => $nbjoueurs, 'idj1' => $idj1]);
      $idpartie=$partie->idpartie;

      //A utilisaer quand la partie est lancée
      //Pioche::initialiserPioche($idpartie);


      //Main::initialiserMains($idpartie,$nbjoueurs);
      //Pioche::tirerCarte($idpartie,$idj1);
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
          $this->idj2=Utilisateur::getUtilisateurFromPseudo($pseudo)->id;
          $this->save();
          return true;
        } else {
          return false;
        }
      } else if ($this->nbjoueurs == 3) {
        if (empty($this->nomj2)) {
          $this->nomj2=$pseudo;
          $this->idj2=Utilisateur::getUtilisateurFromPseudo($pseudo)->id;
          $this->save();
          return true;
        } else {
          if (empty($this->nomj3)) {
            $this->nomj3=$pseudo;
            $this->idj3=Utilisateur::getUtilisateurFromPseudo($pseudo)->id;
            $this->save();
            return true;
          } else {
            return false;
          }
        }
      } else {
        if (empty($this->nomj2)) {
          $this->nomj2=$pseudo;
          $this->idj2=Utilisateur::getUtilisateurFromPseudo($pseudo)->id;
          $this->save();
          return true;
        } else {
          if (empty($this->nomj3)) {
            $this->nomj3=$pseudo;
            $this->idj3=Utilisateur::getUtilisateurFromPseudo($pseudo)->id;
            $this->save();
            return true;
          } else {
            if (empty($this->nomj4)) {
              $this->nomj4=$pseudo;
              $this->idj4=Utilisateur::getUtilisateurFromPseudo($pseudo)->id;
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

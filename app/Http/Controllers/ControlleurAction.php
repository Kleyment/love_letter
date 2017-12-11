<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilisateur;
use App\Pioche;
use App\Defausse;
use App\Tour;
use App\Partie;
use App\Main;

class ControlleurAction extends Controller {
    public static function piocher($idpartie) {
      $etat=array();
      $etat['type']=2;
      if (isset($_COOKIE['pseudo']) && isset($_COOKIE['token'])) {
        $pseudo=$_COOKIE['pseudo'];
        $token=$_COOKIE['token'];
        $utilisateur=Utilisateur::getUtilisateurFromPseudoToken($pseudo,$token);

        $partie=Partie::getPartie($idpartie);
        if ($partie->idj1 == $utilisateur->id) {
          if (Tour::quiPeutPiocher($idpartie) == 1) {
            Pioche::tirerCarte($idpartie,$utilisateur->id);
            Tour::create(['idpartie' => $idpartie, 'nbtour' => Tour::nouveauTour($idpartie), 'idjoueur' => $utilisateur->id, 'typeaction' => 1, 'idvictime' => -1, 'typecarte' => -1]);
          } else {
            $etat['text']=Tour::quiPeutFaireQuoi($idpartie);
          }
        } else if ($partie->idj2 == $utilisateur->id) {
          if (Tour::quiPeutPiocher($idpartie) == 2) {
            Pioche::tirerCarte($idpartie,$utilisateur->id);
            Tour::create(['idpartie' => $idpartie, 'nbtour' => Tour::nouveauTour($idpartie), 'idjoueur' => $utilisateur->id, 'typeaction' => 1, 'idvictime' => -1, 'typecarte' => -1]);
          } else {
            $etat['text']=Tour::quiPeutFaireQuoi($idpartie);
          }
        }
      } else {
        $etat['text']="Vous n'êtes pas un joueur actif sur cette partie";
      }
      return $etat;
    }

    public static function defausser($idpartie, $idcarte) {
      $etat=array();
      $etat['type']=2;
      if (isset($_COOKIE['pseudo']) && isset($_COOKIE['token'])) {
        $pseudo=$_COOKIE['pseudo'];
        $token=$_COOKIE['token'];
        $utilisateur=Utilisateur::getUtilisateurFromPseudoToken($pseudo,$token);

        $partie=Partie::getPartie($idpartie);
        if ($partie->idj1 == $utilisateur->id) {
          if (Tour::quiPeutDefausser($idpartie) == 1) {
            if ($idcarte == 0 || $idcarte == 1) {
              $main=Main::getMain($idpartie,$utilisateur->id);
              $typecarte=$main->retournerCarte($idcarte);
              Defausse::defausserCarte($idpartie,$typecarte,$utilisateur->id);
              Tour::create(['idpartie' => $idpartie, 'nbtour' => Tour::nouveauTour($idpartie), 'idjoueur' => $utilisateur->id, 'typeaction' => 2, 'idvictime' => -1, 'typecarte' => -1]);
            } else {
              $etat['text']="Vous ne pouvez pas défausser les cartes d'un autre joueur";
            }
          } else {
            $etat['text']=Tour::quiPeutFaireQuoi($idpartie);
          }
        } else if ($partie->idj2 == $utilisateur->id) {
          if (Tour::quiPeutDefausser($idpartie) == 2) {
            if ($idcarte == 2 || $idcarte == 3) {
              $main=Main::getMain($idpartie,$utilisateur->id);
              $typecarte=$main->retournerCarte($idcarte);
              Defausse::defausserCarte($idpartie,$typecarte,$utilisateur->id);
              Tour::create(['idpartie' => $idpartie, 'nbtour' => Tour::nouveauTour($idpartie), 'idjoueur' => $utilisateur->id, 'typeaction' => 2, 'idvictime' => -1, 'typecarte' => -1]);
            } else {
              $etat['text']="Vous ne pouvez pas défausser les cartes d'un autre joueur";
            }
          } else {
            $etat['text']=Tour::quiPeutFaireQuoi($idpartie);
          }
        }
    } else {
      $etat['text']="Vous n'êtes pas un joueur actif sur cette partie";
    }
    return $etat;
  }
}

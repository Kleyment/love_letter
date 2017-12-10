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
      if (isset($_COOKIE['pseudo']) && isset($_COOKIE['token'])) {
        $pseudo=$_COOKIE['pseudo'];
        $token=$_COOKIE['token'];
        $utilisateur=Utilisateur::getUtilisateurFromPseudoToken($pseudo,$token);

        $partie=Partie::getPartie($idpartie);
        if ($partie->idj1 == $utilisateur->id) {
          if (Tour::quiPeutPiocher($idpartie) == 1) {
            Pioche::tirerCarte($idpartie,$utilisateur->id);
          }
        } else if ($partie->idj1 == $utilisateur->id) {
          if (Tour::quiPeutPiocher($idpartie) == 2) {
            Pioche::tirerCarte($idpartie,$utilisateur->id);
          }
        }
      }
    }

    public static function defausser($idpartie, $idcarte) {
      if (isset($_COOKIE['pseudo']) && isset($_COOKIE['token'])) {
        $pseudo=$_COOKIE['pseudo'];
        $token=$_COOKIE['token'];
        $utilisateur=Utilisateur::getUtilisateurFromPseudoToken($pseudo,$token);

        $partie=Partie::getPartie($idpartie);
        if ($partie->idj1 == $utilisateur->id) {
          if (Tour::quiPeutDefausser($idpartie) == 1) {
            $main=Main::getMain($idpartie,$utilisateur->id);
            $typecarte=$main->retournerCarte($idcarte);
            Defausse::defausserCarte($idpartie,$typecarte,$utilisateur->id);
          }
        } else if ($partie->idj1 == $utilisateur->id) {
          if (Tour::quiPeutDefausser($idpartie) == 2) {
            $main=Main::getMain($idpartie,$utilisateur->id);
            $typecarte=$main->retournerCarte($idcarte);
            Defausse::defausserCarte($idpartie,$typecarte,$utilisateur->id);
          }
        }
    }
  }
}

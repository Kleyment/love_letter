<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilisateur;
use App\Partie;

class ControlleurParties extends Controller {

  public static function toutesLesParties() {
    $reponse=array('type' => 3);
    $parties=Partie::toutesLesParties();
    $i=0;
    foreach ($parties as $partie) {
      $reponse[$i]=$partie;
      $i=$i+1;
    }
    $reponse['taille']=$i;
    return $reponse;
  }

  public function creerPartie($nbjoueurs) {
    if (isset($_COOKIE['pseudo']) && isset($_COOKIE['token'])) {
      $pseudo=$_COOKIE['pseudo'];
      $token=$_COOKIE['token'];
      $utilisateur=Utilisateur::getUtilisateurFromPseudoToken($pseudo,$token);
      if ($utilisateur && !($utilisateur->aUnePartie())) {
        $idpartie=Partie::creerPartie($pseudo,$nbjoueurs);
        $utilisateur->assignerAUnePartie($idpartie);
      } else {
        //TODO retourner du JSON
        return "";
      }
    } else {
      return "";
    }
  }

  public function rejoindrePartie($idpartie) {
    if (isset($_COOKIE['pseudo']) && isset($_COOKIE['token'])) {
      $pseudo=$_COOKIE['pseudo'];
      $token=$_COOKIE['token'];
      $utilisateur=Utilisateur::getUtilisateurFromPseudoToken($pseudo,$token);
      if ($utilisateur && !($utilisateur->aUnePartie())) {
        $partie=Partie::getPartie($idpartie);
        if ($partie) {
          $ok=$partie->rejoindrePartie($pseudo);
          if ($ok) {
            $utilisateur->assignerAUnePartie($idpartie);
          } else {
            return "";
          }
        } else {
          return "";
        }
      } else {
        return "";
      }
    } else {
      return "";
    }
  }
}
?>

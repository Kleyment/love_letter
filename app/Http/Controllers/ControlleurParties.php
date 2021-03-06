<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilisateur;
use App\Partie;
use App\Pioche;
use App\Main;

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
        header('Location: /partie/'.$idpartie.'/',true,302);
        exit();
      } else {
        //Vous n'êtes plus connecté ou alors vous êtes déjà dans une partie
        //Vue par defaut
        return view('welcome');
      }
    } else {
      //Vous n'êtes plus connecté
      //Vue par défaut
      return view('welcome');
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
            if ($partie->isPartiePleine()) {
              //A utiliser quand la partie est lancée
              Pioche::initialiserPioche($partie->idpartie);
              Main::initialiserMains($partie->idpartie,$partie->nbjoueurs);
              Pioche::tirerCarte($idpartie,$partie->idj1);
              Pioche::tirerCarte($idpartie,$utilisateur->id);
            }
            header('Location: /partie/'.$idpartie.'/',true,302);
            exit();
          } else {
            //Vous ne pouvez pas rejoindre cette partie
            //Vue partie
            return view('welcome');
          }
        } else {
          //La partie n'existe plus
          //Vue partie
          return view('welcome');
        }
      } else if ($utilisateur && ($utilisateur->idpartie == $idpartie)) {
        header('Location: /partie/'.$idpartie.'/',true,302);
        exit();
      } else {
        //Vous n'êtes pas connecté mais vous avez déjà une partie
        //Vue par défaut
        return view('welcome');
      }
    } else {
      //Vous n'êtes pas connecté mais vous avez déjà une partie
      //Vue par défaut
      return view('welcome');
    }
  }
}
?>

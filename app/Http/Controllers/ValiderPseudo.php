<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilisateur;

class ValiderPseudo extends Controller
{
  public function validerPseudo($pseudo) {
    $reponse=array('type' => 1);

    if (strlen($pseudo) < 4) {
      $reponse['pseudoOk']=false;
      $reponse['reason']='Le pseudo est inférieur à 4 caractères';
    } else {
      if (Utilisateur::getUtilisateurFromPseudo($pseudo)) {
        $reponse['pseudoOk']=false;
        $reponse['reason']='Quelqu\'un a déjà ce pseudo';
      } else {
        Utilisateur::creerUtilisateur($pseudo);
        $reponse['pseudoOk']=true;
      }
    }
    return $reponse;
  }

  public function annulerPseudo() {
    $reponse=array('type' => 2);

    if (isset($_COOKIE['pseudo']) && isset($_COOKIE['token'])) {
      $pseudo=$_COOKIE['pseudo'];
      $token=$_COOKIE['token'];
      $utilisateur=Utilisateur::getUtilisateurFromPseudoToken($pseudo,$token);
      if ($utilisateur) {
        $utilisateur->annulerPseudo();
        $reponse['annulerPseudoOk']=true;
      } else {
        $reponse['annulerPseudoOk']=false;
        $reponse['reason']='Ce n\'est pas votre pseudo';
      }
    } else {
      $reponse['annulerPseudoOk']=false;
      $reponse['reason']='Vous n\'avez pas de pseudo ou vous n\'avez pas de jeton d\'authentification';
    }
    Utilisateur::detruireCookiesUtilisateur();
    return $reponse;
  }
}

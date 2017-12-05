<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilisateur;

class Welcome extends Controller
{
    //Retourne la vue de l'accueil pour les nouveaux et les joueurs sans parties
    //Sinon redirige le joueur vers sa partie
    public static function welcome() {
      if (isset($_COOKIE['pseudo']) && isset($_COOKIE['token'])) {
        $pseudo=$_COOKIE['pseudo'];
        $token=$_COOKIE['token'];
        $utilisateur=Utilisateur::getUtilisateurFromPseudoToken($pseudo,$token);
        if ($utilisateur) {
          if ($utilisateur->aUnePartie()) {
            header('Location: /partie/'.$utilisateur->idpartie.'/',true,302);
            exit();
          } else {
            return view('welcome');
          }
        } else {
          return view('welcome');
        }
      } else {
        return view('welcome');
      }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilisateur;

class Welcome extends Controller
{
    //Retourne la vue de l'accueil pour les nouveaux et les joueurs sans parties
    //Sinon redirige le joueur vers sa partie
    public static function welcome() {
      if (isset($_COOKIE['pseudo'])) {
          $pseudo=$_COOKIE['pseudo'];
          if (Utilisateur::aUnePartie($pseudo)) {
            //TODO
          } else {
            return view('welcome', ['validerPseudo' => true]);
          }
      } else {
        return view('welcome', ['validerPseudo' => false]);
      }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilisateur;
use App\Etat;
use App\Main;
use App\Partie;
use App\Defausse;
use App\Pioche;

class ControlleurEtats extends Controller
{
  public static function etatPartie($idpartie) {
    $etat=array();
    $etat['type']=1;

    $partie=Partie::getPartie($idpartie);

    $idj1=$partie->idj1;
    $idj2=$partie->idj2;

    $mainj1=Main::getMain($idpartie,$idj1);
    $mainj2=Main::getMain($idpartie,$idj2);

    $defausse=Defausse::cardOntTheTop($idpartie);
    $nbpioche=Pioche::nbPioche($idpartie);
    $nbdefausse=Defausse::nbDefausse($idpartie);

    $etat['idpartie']=$idpartie;

      if ($mainj1 && $mainj1->carteg != -1) {
        $etat['carteg1']=9;
      } else {
        $etat['carteg1']=-1;
      }

      if ($mainj1 && $mainj1->carted != -1) {
        $etat['carted1']=9;
      } else {
        $etat['carted1']=-1;
      }

      if ($mainj2 && $mainj2->carteg != -1) {
        $etat['carteg2']=9;
      } else {
        $etat['carteg2']=-1;
      }

      if ($mainj2 && $mainj2->carted != -1) {
        $etat['carted2']=9;
      } else {
        $etat['carted2']=-1;
      }

      if (isset($_COOKIE['pseudo']) && isset($_COOKIE['token'])) {
        $pseudo=$_COOKIE['pseudo'];
        $token=$_COOKIE['token'];
        $utilisateur=Utilisateur::getUtilisateurFromPseudoToken($pseudo,$token);
        $idutilisateur=$utilisateur->id;

      if ($mainj1 && $mainj1->idjoueur == $idutilisateur) {
        if ($etat['carteg1'] != -1) {
          $etat['carteg1']=$mainj1->carteg;
        }
        if ($etat['carted1'] != -1) {
          $etat['carted1']=$mainj1->carted;
        }
      } else if ($mainj2 && $mainj2->idjoueur == $idutilisateur) {
        if ($etat['carteg2'] != -1) {
          $etat['carteg2']=$mainj2->carteg;
        }
        if ($etat['carted2'] != -1) {
          $etat['carted2']=$mainj2->carted;
        }
      }
    }

    $etat['carted3']=-1;
    $etat['carteg3']=-1;

    $etat['carted4']=-1;
    $etat['carteg4']=-1;

    $etat['defausse']=$defausse;
    $etat['nbdefausse']=$nbdefausse;
    $etat['nbpioche']=$nbpioche;

    return $etat;
  }
}

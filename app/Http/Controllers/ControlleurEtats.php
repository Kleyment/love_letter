<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    if ($mainj1) {
      $etat['carteg1']=$mainj1->carteg;
      $etat['carted1']=$mainj1->carted;
    } else {
      $etat['carteg1']=-1;
      $etat['carted1']=-1;
    }

    if ($mainj2) {
      $etat['carteg2']=$mainj2->carteg;
      $etat['carted2']=$mainj2->carted;
    } else {
      $etat['carteg2']=-1;
      $etat['carted2']=-1;
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

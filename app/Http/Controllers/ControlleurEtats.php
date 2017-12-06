<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Etat;

class ControlleurEtats extends Controller
{
  public static function etatPartie($idpartie) {
    $etat=Etat::where('idpartie',$idpartie)->get()->first();
    $etat['type']=1;
    return $etat;
  }
}

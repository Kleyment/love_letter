<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utilisateur;

class ValiderPseudo extends Controller
{
  public function validerPseudo($pseudo)
  {
    $reponse=array('type' => 1);

    if (strlen($pseudo) < 4) {
      $reponse['pseudoOk']=false;
      $reponse['reason']='Le pseudo est inférieur à 4 caractères';
    } else {
      $pseudolibre=Utilisateur::utiliserPseudo($pseudo);
      if (!$pseudolibre) {
        $reponse['pseudoOk']=false;
        $reponse['reason']='Quelqu\'un a déjà ce pseudo';
      } else {
        $reponse['pseudoOk']=true;
      }
    }
    return $reponse;
  }
}

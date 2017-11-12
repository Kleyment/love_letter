<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
  public $timestamps = false;

  protected $attributes = array(
    'idpartie' => -1
  );

  protected $fillable = [
      'pseudo', 'token', 'idpartie',
  ];

  public static function creerUtilisateur($pseudo) {
    //String à hasher, il contient un sel, le temps actuel et un nombre aléatoire
    $stringToHash="azez5f6ze5".time().rand();
    $token=hash("sha256",$stringToHash);
    setcookie('pseudo',$pseudo,0,'/');
    setcookie('token',$token,0,'/');
    Utilisateur::create(["pseudo" => $pseudo, 'token' => $token]);
  }

  public static function getUtilisateurFromPseudo($pseudo) {
    return Utilisateur::where('pseudo', $pseudo)->get()->first();
  }

  public static function annulerPseudo() {
    if (isset($_COOKIE['pseudo']) && isset($_COOKIE['token'])) {
      $pseudo=$_COOKIE['pseudo'];
      $token=$_COOKIE['token'];
      $utilisateur=Utilisateur::where('pseudo', $pseudo)->get()->first();
      if (($utilisateur) && ($utilisateur->token == $token)) {
        setcookie("pseudo", "", time() - 3600,'/');
        setcookie("token", "", time() - 3600,'/');
        $utilisateur->delete();
        return true;
      } else {
        setcookie("pseudo", "", time() - 3600,'/');
        setcookie("token", "", time() - 3600,'/');
        return false;
      }
    }
    return false;
  }


  public static function aUnePartie($pseudo) {
    if ((Utilisateur::where('pseudo', $pseudo)->get()->first()->idpartie) == -1) {
      return false;
    } else if ((Utilisateur::where('pseudo', $pseudo)->get()->first()->idpartie) > -1) {
      return true;
    }
  }
}

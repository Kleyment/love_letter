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

  public static function getUtilisateurFromPseudoToken($pseudo,$token) {
    //TODO Ajouter un where pour le token
    $utilisateur=Utilisateur::where('pseudo', $pseudo)->get()->first();
    if ($utilisateur && ($utilisateur->token == $token)) {
      return $utilisateur;
    } else {
      return false;
    }
  }

  public static function detruireCookiesUtilisateur() {
    setcookie("pseudo", "", time() - 3600,'/');
    setcookie("token", "", time() - 3600,'/');
  }

  public function annulerPseudo() {
    $this->delete();
  }

  public function aUnePartie() {
    if ($this->idpartie == -1) {
      return false;
    } else {
      return true;
    }
  }
}

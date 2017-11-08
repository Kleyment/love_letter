<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{

  protected $attributes = array(
    'idpartie' => -1
  );

  protected $fillable = [
      'pseudo', 'token', 'idpartie',
  ];

  public static function utiliserPseudo($pseudo) {
    self::creerCookies($pseudo);
    return true;
  }

  public static function creerCookies($pseudo) {
    $stringToHash="azez5f6ze5".time().rand();
    $token=hash("sha256",$stringToHash);
    setcookie('pseudo',$pseudo);
    setcookie('token',$token);
    Utilisateur::create(["pseudo" => $pseudo, 'token' => $token]);
  }
}

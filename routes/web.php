<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Pour le 11 décembre
use Controllers\ValiderPseudo;

Route::get('/',"Welcome@welcome");

Route::get('/play', function () {
    return view('play');
});

Route::get('/name/{pseudo}',"ValiderPseudo@validerPseudo");
Route::get('/cancelname/',"ValiderPseudo@annulerPseudo");

Route::get('/creerPartie/{nbjoueurs}',"ControlleurParties@creerPartie");
Route::get('/rejoindrePartie/{idpartie}',"ControlleurParties@rejoindrePartie");

//Utilisé par l'AJAX de welcome.js pour avoir périodiquement les parties
Route::get('/parties',"ControlleurParties@toutesLesParties");

Route::get('/partie/{idpartie}', function() {
  return view('play');
});

Route::get('/partie/{idpartie}/update', 'ControlleurEtats@etatPartie');

Route::get('/partie/{idpartie}/action/piocher', 'ControlleurAction@piocher');
Route::get('/partie/{idpartie}/action/defausser/{idcarte}', 'ControlleurAction@defausser');
//Route::get('/update',)
//Ici une rediraction vers un controlleur qui renvoie un objet Etat (en json)
//avec un filtre des cartes selon le joueur

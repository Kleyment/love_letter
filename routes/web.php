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
Route::get('/parties',"ControlleurParties@toutesLesParties");



//Route::get('/update',)
//Ici une rediraction vers un controlleur qui renvoie un objet Etat (en json)
//avec un filtre des cartes selon le joueur

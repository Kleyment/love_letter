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

Route::get('/', function () {
    return view('play');
});


//Route::get('/update',)
//Ici une rediraction vers un controlleur qui renvoie un objet Etat (en json)
//avec un filtre des cartes selon le joueur

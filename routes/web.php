<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


Route::get('/sorteio', 'App\Http\Controllers\Sorteio@montaEquipe');

Route::get('/novo_jogador', function() {
    $players = new App\Http\Controllers\Sorteio();
    return view('novo_jogador', ['jogadores' => $players->_getPlayers()]);
});
Route::post('/novo_jogador', 'App\Http\Controllers\Sorteio@storeNewPlayer');

Route::get('/configuracao', function() {
    $configuracao = new App\Http\Controllers\Sorteio();
    return view('configuracao', ['configuracao' => $configuracao->teamLimit()]);
});
Route::post('/configuracao', 'App\Http\Controllers\Sorteio@_setConfigurations');

<?php

use App\Http\Controllers\TransacaoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'transaction'], function () {
    Route::post('/', [TransacaoController::class, 'criarTransacao']);
    Route::get('/{id}', [TransacaoController::class, 'reverterTransacao']);
});
// ->middleware('HoraLimiteTransacao');

Route::group(['prefix' => 'usuario'], function () {
    Route::post('/', [UsuarioController::class, 'criarUsuario']);
    Route::get('/{cpf}', [UsuarioController::class, 'buscarUsuarioPorCpf']);
});

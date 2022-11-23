<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;

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

Route::get('/token', [AuthController::class, 'getToken']);

// Usuarios
    # Muestra todos los usuarios
    Route::get('/usuarios', [UsersController::class, 'all']);

    # Cambia de página de usuarios especificando el parametro page
    Route::get('/usuarios/p/{page?}', [UsersController::class, 'all']);

    # Crea un nuevo usuario
    Route::post('/usuarios', [UsersController::class, 'create'])
        ->middleware('auth:sanctum');

/*Route::middleware('auth:sanctum')
    ->get('/user', fn (Request $request) => $request->user());*/

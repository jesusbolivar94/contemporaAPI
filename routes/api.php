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

Route::get('/getToken', [AuthController::class, 'getToken']);

// Users
    Route::get('/usuarios', [UsersController::class, 'all']);
    Route::get('/usuarios/p/{page?}', [UsersController::class, 'all']);

/*Route::middleware('auth:sanctum')
    ->get('/user', fn (Request $request) => $request->user());*/

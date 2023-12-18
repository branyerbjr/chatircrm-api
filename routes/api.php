<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\ClienteController;
use App\Http\Controllers\Auth\AuthController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas por autenticación
Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});



Route::group(['prefix' => 'clientes'], function () {
    Route::get('/', [ClienteController::class, 'index']);
    Route::post('/', [ClienteController::class, 'store']);
    Route::get('/{id}', [ClienteController::class, 'show']);
    Route::put('/{id}', [ClienteController::class, 'update']);
    Route::delete('/{id}', [ClienteController::class, 'destroy']);
});

<?php

use App\Http\Controllers\InstalacionController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CursoController;

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

Route::controller(ProductoController::class)->prefix('productos')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{id}', 'show');
    Route::post('/{id}', 'update');
    Route::put('/{id}', 'put');
    Route::delete('/{id}', 'destroy');
});

Route::controller(UsuarioController::class)->prefix('usuarios')->group(function () {
    Route::get('/', 'index');
    Route::get('/{dni}', 'show');
    Route::post('/', 'store');
    Route::patch('/{dni}', 'update');
    Route::delete('/{dni}', 'destroy');
});

Route::controller(InstalacionController::class)->prefix('instalaciones')->group(function () {
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::post('/', 'store');
    Route::patch('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});


Route::controller(CursoController::class)->prefix('curso')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{id}', 'show');
    Route::post('/{id}', 'update');
    Route::put('/{id}', 'put');
    Route::delete('/{id}', 'destroy');
});

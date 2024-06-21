<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\Claves_SATController;
use App\Http\Controllers\LineasController;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\RefaccionesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/usuarios', [AuthController::class, 'index']);
    Route::post('/usuarios', [AuthController::class, 'store']);
});

Route::post('/refacciones', [RefaccionesController::class, 'store']);
Route::get('/refacciones', [RefaccionesController::class, 'index']);
Route::get('/refacciones/{id}', [RefaccionesController::class, 'show']);
Route::put('/refacciones/{id}', [RefaccionesController::class, 'update']);
Route::delete('/refacciones/{id}', [RefaccionesController::class, 'destroy']);
Route::post('/refacciones/import', [RefaccionesController::class, 'storeExcel']);

// endpoints para categorias
Route::get('/categorias', [CategoriasController::class, 'index']);
Route::post('/categorias', [CategoriasController::class, 'store']);
Route::get('/categorias/{id}', [CategoriasController::class, 'show']);
Route::put('/categorias/{id}', [CategoriasController::class, 'update']);
Route::delete('/categorias/{id}', [CategoriasController::class, 'destroy']);

// endpoints para marcas
Route::get('/marcas', [MarcasController::class, 'index']);
Route::post('/marcas', [MarcasController::class, 'store']);
Route::get('/marcas/{id}', [MarcasController::class, 'show']);
Route::put('/marcas/{id}', [MarcasController::class, 'update']);
Route::delete('/marcas/{id}', [MarcasController::class, 'destroy']);

// endpoints para lineas
Route::get('/lineas', [LineasController::class, 'index']);
Route::post('/lineas', [LineasController::class, 'store']);
Route::get('/lineas/{id}', [LineasController::class, 'show']);
Route::put('/lineas/{id}', [LineasController::class, 'update']);
Route::delete('/lineas/{id}', [LineasController::class, 'destroy']);

// endpoints para claves_sat
Route::get('/claves_sat', [Claves_SATController::class, 'index']);
Route::post('/claves_sat', [Claves_SATController::class, 'store']);
Route::get('/claves_sat/{id}', [Claves_SATController::class, 'show']);
Route::put('/claves_sat/{id}', [Claves_SATController::class, 'update']);
Route::delete('/claves_sat/{id}', [Claves_SATController::class, 'destroy']);

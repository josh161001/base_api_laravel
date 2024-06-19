<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\RefaccionesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/refacciones', [RefaccionesController::class, 'store']);
Route::get('/refacciones', [RefaccionesController::class, 'index']);
Route::get('/refacciones/{id}', [RefaccionesController::class, 'show']);
Route::put('/refacciones/{id}', [RefaccionesController::class, 'update']);
Route::delete('/refacciones/{id}', [RefaccionesController::class, 'destroy']);

// endpoints para categorias
Route::get('/categorias', [CategoriasController::class, 'index']);
Route::post('/categorias', [CategoriasController::class, 'store']);
Route::get('/categorias/{id}', [CategoriasController::class, 'show']);
Route::put('/categorias/{id}', [CategoriasController::class, 'update']);
Route::delete('/categorias/{id}', [CategoriasController::class, 'destroy']);

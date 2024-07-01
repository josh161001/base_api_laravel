<?php

use App\Http\Controllers\Archivos\ArchivosController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Categorias\CategoriasController;
use App\Http\Controllers\Claves_SAT\Claves_SATController;
use App\Http\Controllers\Clientes\ClientesController;
use App\Http\Controllers\Lineas\LineasController;
use App\Http\Controllers\Marcas\MarcasController;
use App\Http\Controllers\Pruueba\PruebaController;
use App\Http\Controllers\Refacciones\RefaccionesController;
use App\Http\Controllers\Vehiculos\VehiculosController;
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


Route::get('/marcas', [MarcasController::class, 'index']);
Route::post('/marcas', [MarcasController::class, 'store']);
Route::get('/marcas/{id}', [MarcasController::class, 'show']);
Route::put('/marcas/{id}', [MarcasController::class, 'update']);
Route::delete('/marcas/{id}', [MarcasController::class, 'destroy']);

Route::get('/categorias', [CategoriasController::class, 'index']);
Route::post('/categorias', [CategoriasController::class, 'store']);
Route::get('/categorias/{id}', [CategoriasController::class, 'show']);
Route::put('/categorias/{id}', [CategoriasController::class, 'update']);
Route::delete('/categorias/{id}', [CategoriasController::class, 'destroy']);

Route::get('/lineas', [LineasController::class, 'index']);
Route::post('/lineas', [LineasController::class, 'store']);
Route::get('/lineas/{id}', [LineasController::class, 'show']);
Route::put('/lineas/{id}', [LineasController::class, 'update']);
Route::delete('/lineas/{id}', [LineasController::class, 'destroy']);

Route::get('/claves-sat', [Claves_SATController::class, 'index']);
Route::post('/claves-sat', [Claves_SATController::class, 'store']);
Route::get('/claves-sat/{id}', [Claves_SATController::class, 'show']);
Route::put('/claves-sat/{id}', [Claves_SATController::class, 'update']);
Route::delete('/claves-sat/{id}', [Claves_SATController::class, 'destroy']);


Route::post('/archivos/{id}', [ArchivosController::class, 'store']);
Route::delete('/archivos/{id}', [ArchivosController::class, 'destroy']);



Route::get('/vehiculos', [VehiculosController::class, 'index']);

Route::group(['middleware' => ['auth:sanctum']], function () {
});
Route::get('/clientes', [ClientesController::class, 'index']);
Route::post('/clientes', [ClientesController::class, 'store']);
Route::get('/clientes/{id}', [ClientesController::class, 'show']);
Route::put('/clientes/{id}', [ClientesController::class, 'update']);
Route::delete('/clientes/{id}', [ClientesController::class, 'destroy']);

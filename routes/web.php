<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RefaccionesController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [RefaccionesController::class, 'index']);
Route::post('/refacciones', [RefaccionesController::class, 'store']);
Route::get('/refacciones/{id}', [RefaccionesController::class, 'show']);
Route::put('/refacciones/{id}', [RefaccionesController::class, 'update']);
Route::delete('/refacciones/{id}', [RefaccionesController::class, 'destroy']);




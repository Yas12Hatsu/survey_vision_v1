<?php
use App\Http\Controllers\PreguntasListController;
use App\Http\Controllers\RespuestaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Cors;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('preguntaslist', [PreguntasListController::class, 'index']);
Route::post('respuestas', [RespuestaController::class, 'storeAPI'])->middleware('cors');
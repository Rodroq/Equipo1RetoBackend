<?php

use App\Http\Controllers\EquipoController;
use App\Http\Controllers\JugadorController;
use App\Http\Controllers\RetoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('equipos',EquipoController::class);
Route::apiResource('jugadores',JugadorController::class);
Route::apiResource('retos',RetoController::class);

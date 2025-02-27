<?php

use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\JugadorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PartidoController;
use App\Http\Controllers\RetoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login'])->name('login');

Route::apiResource('usuarios',UserController::class);
Route::apiResource('equipos', EquipoController::class);
Route::apiResource('jugadores', JugadorController::class)->parameters(['jugadores' => 'jugador']);
Route::apiResource('retos', RetoController::class)->only('index', 'show');
Route::apiResource('partidos', PartidoController::class)->only('index', 'show', 'store');

Route::controller(ImagenController::class)->group(function (){
    Route::get('imagenes/{imageable_type}','index')->name('imagenes.index');
    Route::get('imagenes/{imageable_type}/{slug}','show')->name('imagenes.show');
    Route::post('imagenes/{imageable_type}/{slug}','store')->name('imagenes.store');
    Route::post('imagenes/{imageable_type}/{slug}/{file_name}','update')->name('imagenes.update');
    Route::delete('imagenes/{imageable_type}/{slug}/{file_name}','destroy')->name('imagenes.destroy');
});


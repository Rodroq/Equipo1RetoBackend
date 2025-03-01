<?php

use App\Http\Controllers\{EquipoController, MediaController, JugadorController, LoginController, PartidoController, PublicacionController, RetoController, UserController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login'])->name('login');

Route::apiResource('equipos', EquipoController::class);
Route::apiResource('jugadores', JugadorController::class)->parameters(['jugadores' => 'jugador']);
Route::apiResource('partidos', PartidoController::class)->only('index', 'show', 'store');
Route::apiResource('retos', RetoController::class)->only('index', 'show');
Route::apiResource('usuarios', UserController::class);

Route::controller(PublicacionController::class)->group(function () {
    Route::get('publicaciones', 'index')->name('imagenes.index');
    Route::get('publicaciones/{publicacion}', 'show')->name('imagenes.show');
    Route::post('publicaciones', 'store')->name('imagenes.store');
    Route::put('publicaciones/{publicacion}', 'update')->name('imagenes.update');
    Route::delete('publicaciones/{publicacion}', 'destroy')->name('imagenes.destroy');
});

Route::controller(MediaController::class)->group(function () {
    Route::post('imagenes/{imageable_type}/{slug}', 'store')->name('imagenes.store');
    Route::post('imagenes/{imageable_type}/{slug}/{file_name}', 'update')->name('imagenes.update');
    Route::delete('imagenes/{imageable_type}/{slug}/{file_name}', 'destroy')->name('imagenes.destroy');
});

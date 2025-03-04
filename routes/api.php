<?php

use App\Http\Controllers\{ActaController, EquipoController, InscripcionController, MediaController, JugadorController, LoginController, PartidoController, PublicacionController, RetoController, UserController};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login'])->name('login');

Route::apiResource('actas', ActaController::class)->except('show');
Route::apiResource('equipos', EquipoController::class);
Route::apiResource('jugadores', JugadorController::class)->parameters(['jugadores' => 'jugador']);
Route::apiResource('partidos', PartidoController::class)->except('update', 'destroy');
Route::apiResource('publicaciones', PublicacionController::class)->parameters(['publicaciones' => 'publicacion']);
Route::apiResource('retos', RetoController::class)->only('index', 'show');
Route::apiResource('usuarios', UserController::class);
Route::apiResource('inscripciones', InscripcionController::class)->only('index', 'update')->parameters(['inscripciones' => 'inscripcion']);


Route::controller(MediaController::class)->group(function () {
    Route::get('imagenes', 'index')->name('imagenes.index');
    Route::post('imagenes/{imageable_type}/{slug}', 'store')->name('imagenes.store');
    Route::post('imagenes/{imageable_type}/{slug}/{file_name}', 'update')->name('imagenes.update');
    Route::delete('imagenes/{imageable_type}/{slug}/{file_name}', 'destroy')->name('imagenes.destroy');
});

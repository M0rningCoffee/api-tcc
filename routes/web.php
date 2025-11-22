<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlantaController;
use App\Http\Controllers\SoloController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;

    Route::get('/v1/plantas', [PlantaController::class, 'index'])->name('plantas.index');
    Route::get('/v1/plantas/{id_planta}', [PlantaController::class, 'show'])->name('plantas.show');
    Route::put('/v1/plantas/{planta}', [PlantaController::class, 'updatePlanta'])->name('plantas.update');
    Route::delete('/v1/plantas/{planta}', [PlantaController::class, 'destroyPlanta'])->name('plantas.destroy');
    Route::post('/v1/plantas', [PlantaController::class, 'storePlanta'])->name('plantas.store');


Route::get('/v1/users', [UserController::class, 'index']);

Route::resource('/v1/solos', SoloController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

Route::get('/v1/logs', [LogController::class, 'index']);



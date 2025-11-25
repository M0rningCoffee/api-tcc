<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlantaController;
use App\Http\Controllers\SoloController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\UserController;


    Route::post('/v1/login', [UserController::class, 'login'])->name('users.login');
    Route::post('/v1/logs', [PlantaController::class, 'storeLog'])->name('plantas.storeLog');
    Route::post('/v1/users', [UserController::class, 'storeUser'])->name('users.store');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/v1/plantas', [PlantaController::class, 'index'])->name('plantas.index');
    Route::get('/v1/plantas/{planta}', [PlantaController::class, 'show'])->name('plantas.show');
    Route::put('/v1/plantas/{planta}', [PlantaController::class, 'updatePlanta'])->name('plantas.update');
    Route::delete('/v1/plantas/{planta}', [PlantaController::class, 'destroyPlanta'])->name('plantas.destroy');
    Route::post('/v1/plantas', [PlantaController::class, 'storePlanta'])->name('plantas.store');

    Route::post('/v1/solos', [SoloController::class, 'store'])->name('solos.store');
    Route::delete('/v1/solos/{solo}', [SoloController::class, 'destroy'])->name('solos.destroy');
    Route::get('/v1/solos', [SoloController::class, 'index'])->name('solos.index');


    Route::get('/v1/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::post('/v1/logout', [UserController::class, 'logout']);

    Route::get('/v1/me', function (Request $request) {
        return $request->user();
    });

    Route::get('/v1/logs', [LogController::class, 'index']);
});


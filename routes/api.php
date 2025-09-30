<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\RepartoController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/clientes',                [ClienteController::class, 'crear']);

    Route::post('/ordenes',                 [OrdenController::class, 'crear']);
    Route::post('/ordenes/{orden}/reparto', [OrdenController::class, 'asignarReparto']);

    Route::post('/repartos',                [RepartoController::class, 'crear']);
    Route::get('/repartos/fecha/{fecha}',   [RepartoController::class, 'listarPorFecha']);

    Route::post('/vehiculos',               [VehiculoController::class, 'crear']);
});

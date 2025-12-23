<?php

use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\KontenBiasaController;
use App\Http\Controllers\Api\AspirasiAduanController;
use Illuminate\Support\Facades\Route;

Route::prefix('menu')->group(function () {
    Route::get('/', [MenuController::class, 'index']);
    Route::get('/{id}', [MenuController::class, 'show']);
});

Route::prefix('aspirasi-aduan')->group(function () {
    Route::post('/', [AspirasiAduanController::class, 'store']);
    Route::post('/track', [AspirasiAduanController::class, 'getByEmail']);
});

Route::prefix('pages')->group(function () {
    Route::get('/', [KontenBiasaController::class, 'index']);
    Route::get('/{id}', [KontenBiasaController::class, 'show']);
    Route::get('/url/{url}', [KontenBiasaController::class, 'showByUrl']);
});
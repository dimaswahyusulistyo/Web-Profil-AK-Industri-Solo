<?php

use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\KontenBiasaController;
use App\Http\Controllers\Api\AspirasiAduanController;
use App\Http\Controllers\Api\BeritaController;
use App\Http\Controllers\Api\PengumumanController;
use App\Http\Controllers\Api\LayananController;
use App\Http\Controllers\Api\MitraController;
use App\Http\Controllers\Api\SliderController;
use Illuminate\Support\Facades\Route;

Route::prefix('menu')->group(function () {
    Route::get('/', [MenuController::class, 'index']);
    Route::get('/{id}', [MenuController::class, 'show']);
});

Route::prefix('berita')->group(function () {
    Route::get('/', [BeritaController::class, 'index']);
    Route::get('/latest/{limit?}', [BeritaController::class, 'latest']);
    Route::get('/{id}', [BeritaController::class, 'show']);
    Route::get('/url/{url}', [BeritaController::class, 'showByUrl']);
    Route::get('/kategori/all', [BeritaController::class, 'kategori']);
});

Route::prefix('pengumuman')->group(function () {
    Route::get('/', [PengumumanController::class, 'index']);
    Route::get('/latest/{limit?}', [PengumumanController::class, 'latest']);
    Route::get('/{id}', [PengumumanController::class, 'show']);
});

Route::prefix('layanan')->group(function () {
    Route::get('/', [LayananController::class, 'index']);
    Route::get('/{id}', [LayananController::class, 'show']);
});

Route::prefix('slider')->group(function () {
    Route::get('/', [SliderController::class, 'index']);
    Route::get('/{id}', [SliderController::class, 'show']);
});

Route::prefix('mitra')->group(function () {
    Route::get('/', [MitraController::class, 'index']);
    Route::get('/{id}', [MitraController::class, 'show']);
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
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\PlantScannerController;
use App\Http\Controllers\Api\FruitScannerController;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::prefix('stores')->group(function () {
        Route::get('/show', [StoreController::class, 'index']);
        Route::get('/{id}', [StoreController::class, 'show']);
        Route::post('/', [StoreController::class, 'store']);
        Route::put('/{id}', [StoreController::class, 'update']);
        Route::delete('/{id}', [StoreController::class, 'destroy']);
    });

    //plant scaner apis
    Route::post('/store-plant-qr-code', [PlantScannerController::class, 'store']);
    Route::get('/plant-data', [PlantScannerController::class, 'showPlantData']);
    Route::post('/check-plant-qr-code', [PlantScannerController::class, 'checkQrCode']); // check qr exists

    //fruit scaner apis
    Route::post('/store-fruit-qr-code', [FruitScannerController::class, 'store']);
    Route::get('/fruit-data', [FruitScannerController::class, 'showFruitData']);
    Route::get('/check-fruit-qr-code', [FruitScannerController::class, 'checkQrCode']); // check qr exists


    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [UserController::class, 'adminDashboard']);

    });
});

<?php

use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\CompanyController;
use App\Http\Controllers\Client\DictionaryCategoryController;
use App\Http\Controllers\Client\DictionaryController;
use Illuminate\Support\Facades\Route;

Route::prefix('/users')->group(function() {
    Route::post('/login', [ AuthController::class, 'login' ]);
    Route::post('/check', [ AuthController::class, 'check' ])->middleware('auth:sanctum');

    Route::prefix('/{user_id}')->middleware('auth:sanctum')->group(function() {
        Route::prefix('/company')->group(function() {
            Route::get('/', [ CompanyController::class, 'show' ]);
            Route::put('/', [ CompanyController::class, 'update' ]);
        });
    });
});

Route::middleware(['auth:sanctum'])->group(function() {
    Route::prefix('/dictionaries')->group(function() {
        Route::get('/categories/{category}', [ DictionaryCategoryController::class, 'dictionaries' ]);
        Route::get('/{id}', [ DictionaryController::class, 'dictionaries_by_parent' ]);
    });
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JourneyController;

// Route temporaire pour tester sans token
Route::get('/users/nt', [UserController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/users', [UserController::class, 'create']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    Route::post('/logout', [UserController::class, 'index']);

    Route::get('/trips/{start}/{end}/{date}', [JourneyController::class, 'search']);

    Route::get('/trips', [JourneyController::class, 'index']);
    Route::post('/trips', [JourneyController::class, 'create']);
    Route::get('/trips/{id}', [JourneyController::class, 'show']);
    Route::put('/trips/{id}', [JourneyController::class, 'update']);
    Route::delete('/trips/{id}', [JourneyController::class, 'destroy']);
    
});


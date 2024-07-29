<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

// Route temporaire pour tester
Route::get('/users/nt', [UserController::class, 'index']);

// Route pour la connexion
Route::post('/login', [AuthController::class, 'login']);

// Groupe de routes protégé par le middleware auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'create']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
    // Ajoutez ici d'autres routes protégées
});

//Route::get('/users', [UserController::class, 'index'])->middleware('auth:sanctum');

// Route::post('/users', [UserController::class, 'create']);
// Route::get('/users/{id}', [UserController::class, 'show']);
// Route::put('/users/{id}', [UserController::class, 'update']);
// Route::delete('/users/{id}', [UserController::class, 'destroy']);
//Route::post('/logout', [UserController::class, 'index']);

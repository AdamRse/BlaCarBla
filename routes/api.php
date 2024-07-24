<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\UserController;

Route::get('/users/nt', [UserController::class, 'index']);//Temporaire pour tester

Route::get('/users', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::post('/users', [UserController::class, 'create']);
//Route::post('/logout', [UserController::class, 'index']);

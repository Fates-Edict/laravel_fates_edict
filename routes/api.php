<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/authenticate', [AuthController::class, 'authenticate']);
Route::get('logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
Route::get('me', [AuthController::class, 'me'])->middleware(['auth:sanctum']);
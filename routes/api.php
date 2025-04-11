<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PatientController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/authenticate', [AuthController::class, 'authenticate']);
Route::get('logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
Route::get('me', [AuthController::class, 'me'])->middleware(['auth:sanctum']);

Route::prefix('hospitals')->middleware(['auth:sanctum'])->controller(HospitalController::class)->group(function() {
    Route::get('/', 'index');
    Route::get('/{id}', 'findById');
    Route::post('/', 'store');
    Route::put('/{id}', 'store');
    Route::delete('/{id}', 'destroy');
});

Route::prefix('patients')->middleware(['auth:sanctum'])->controller(PatientController::class)->group(function() {
    Route::get('/', 'index');
    Route::get('/{id}', 'findById');
    Route::post('/', 'store');
    Route::put('/{id}', 'store');
    Route::delete('/{id}', 'destroy');
});
<?php

use App\Http\Controllers\Api\AuthController;
use App\Models\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/movements/{movement}', function (Movement $movement) {
   return $movement;
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

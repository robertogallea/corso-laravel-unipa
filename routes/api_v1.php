<?php

use App\Http\Controllers\Api\V1\MovementController;
use App\Http\Controllers\Api\V1\UserController;

Route::apiResource('/movements', MovementController::class)->middleware('auth:sanctum');
Route::apiResource('/users', UserController::class)->middleware('auth:sanctum');

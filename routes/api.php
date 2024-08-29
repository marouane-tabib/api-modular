<?php

use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/users', Controller::class)->middleware('role:manager');

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);
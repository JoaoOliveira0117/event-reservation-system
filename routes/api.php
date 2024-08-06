<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Route::get('/user', function (Request $request) {
 *   return $request->user();
 * })->middleware('auth:sanctum');
 */

 Route::resource("users", UserController::class);
 Route::resource("events", EventController::class);



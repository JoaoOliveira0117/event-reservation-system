<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Route::get('/user', function (Request $request) {
 *   return $request->user();
 * })->middleware('auth:sanctum');
 */

 // Auth
Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);

 // Protected
Route::middleware('auth:sanctum')->group(function () {

  // Users
  Route::resource("users", UserController::class);

  // Events
  Route::get('events/me', [EventController::class, "getMyEvents"]);
  Route::resource("events", EventController::class);
});




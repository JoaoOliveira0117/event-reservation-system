<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
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
  Route::resource("users", UserController::class)->except(['create']);

  // Events
  Route::get('/events/me', [EventController::class, "getMyEvents"]);
  Route::resource("events", EventController::class)->except(['create']);

  // Tickets
  Route::get('/tickets', [TicketController::class, 'index']);
  Route::get('/tickets/{event}', [TicketController::class, 'show']);
  Route::post("/tickets/{event}", [TicketController::class, "store"]);
  Route::put("/tickets/{event}", [TicketController::class, "update"]);
  Route::delete("/tickets/{event}", [TicketController::class, "destroy"]);
});




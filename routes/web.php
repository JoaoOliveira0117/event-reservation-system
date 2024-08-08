<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/events');
});

Route::get('login', function() {
    return view('login');
})->name('login');

Route::get('register', function() {
    return view('register');
})->name('register');

Route::get('events', function() {
    return view('events');
})->name('events');

Route::get('events/create', function() {
    return view('createEvent');
})->name('createEvent');

Route::get('events/{event}', function() {
    return view('updateEvent');
})->name('updateEvent')->whereUuid('event');

Route::get('tickets', function() {
    return view('tickets');
})->name('tickets');
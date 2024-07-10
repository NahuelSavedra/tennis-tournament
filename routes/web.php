<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tournament',[\App\Http\Controllers\TournamentController::class, 'index',]);
Route::post('/tournament/simulate',[\App\Http\Controllers\TournamentController::class, 'simulate',]);

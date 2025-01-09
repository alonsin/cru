<?php

use App\Http\Controllers\Player\PlayerController;
use App\Http\Controllers\Tournament\TournamentController;
use App\Livewire\Players\Player;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');  // Redirige a la página de login
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::controller(PlayerController::class)->name('player.')->middleware(['auth'])->group(function () {
	Route::get('/player', 'index')->name('index');
});

Route::controller(TournamentController::class)->name('tournament.')->middleware(['auth'])->group(function () {
	Route::get('/tournament', 'index')->name('index');
});

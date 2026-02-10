<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Calendar;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/kalender', Calendar::class)
    ->middleware(['auth', 'verified'])
    ->name('kalender');

Route::get('/mijn-uren', [\App\Http\Controllers\TimeEntryController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('time-entries.index');

require __DIR__.'/settings.php';

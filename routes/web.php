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
require __DIR__.'/settings.php';

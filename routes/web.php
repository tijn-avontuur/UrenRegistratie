<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Calendar;
use App\Livewire\Projects\ProjectDetail;
use App\Livewire\AdminUsers;
use App\Http\Controllers\TimeEntryController;
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

Route::get('/mijn-uren', [TimeEntryController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('time-entries.index');

Route::view('projecten', 'pages.projects')
    ->middleware(['auth', 'verified'])
    ->name('projecten');

Route::get('projecten/{project}', ProjectDetail::class)
    ->middleware(['auth', 'verified'])
    ->name('projecten.detail');

Route::get('/admin/medewerkers', AdminUsers::class)
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.users');

require __DIR__.'/settings.php';

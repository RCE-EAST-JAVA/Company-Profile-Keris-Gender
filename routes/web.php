<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\PublicationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Resource Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/programs/{project}', [ProgramController::class, 'show'])->name('programs.show');

Route::get('/publications', [PublicationController::class, 'index'])->name('publications.index');
Route::get('/publications/{article:slug}', [PublicationController::class, 'show'])->name('publications.show');

Route::get('/people', [PeopleController::class, 'index'])->name('people.index');
Route::get('/people/{staff:slug}', [PeopleController::class, 'show'])->name('people.show');

Route::get('/dashboard', function () {
    return Inertia::location(route('admin.dashboard'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

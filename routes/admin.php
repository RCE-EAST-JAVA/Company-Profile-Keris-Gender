<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HeroBackgroundController;
use App\Http\Controllers\Admin\HeroPhotoController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectImageController;
use App\Http\Controllers\Admin\StaffController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('projects', ProjectController::class)->except(['show']);
    Route::post('projects/{project}/images', [ProjectImageController::class, 'store'])->name('projects.images.store');
    Route::delete('project-images/{image}', [ProjectImageController::class, 'destroy'])->name('images.destroy');
    Route::patch('project-images/{image}/cover', [ProjectImageController::class, 'setCover'])->name('images.cover');

    Route::resource('articles', ArticleController::class)->except(['show']);
    Route::resource('staff', StaffController::class)->except(['show']);
    Route::resource('hero-photos', HeroPhotoController::class)->parameters(['hero-photos' => 'heroPhoto'])->except(['show']);
    Route::get('hero-background', [HeroBackgroundController::class, 'edit'])->name('hero-background.edit');
    Route::put('hero-background', [HeroBackgroundController::class, 'update'])->name('hero-background.update');
    Route::get('about', [AboutController::class, 'edit'])->name('about.edit');
    Route::put('about', [AboutController::class, 'update'])->name('about.update');
    Route::resource('partners', PartnerController::class)->except(['show']);
});

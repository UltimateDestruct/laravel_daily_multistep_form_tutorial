<?php

use App\Http\Controllers\MultiStepController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/dashboard', [MultiStepController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('multi-step', [MultiStepController::class, 'store'])->name('multi-step.store'); 
    Route::inertia('success', 'Success')->name('success');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

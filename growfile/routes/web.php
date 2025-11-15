<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSearchController;
use App\Http\Controllers\ProfessionalProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/professional_profile', [ProfessionalProfileController::class, 'show']
)->middleware(['auth', 'verified'])->name('professional_profile.show');

Route::get('/profile_search', [ProfileSearchController::class, 'show']
)->name('profile_search.show');

require __DIR__.'/auth.php';

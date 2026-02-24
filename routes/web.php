<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSearchController;
use App\Http\Controllers\ProfessionalProfileController;
use App\Http\Controllers\RegisterProfileController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::prefix('{locale}')->get('/', function () {
    return view('welcome');
})->name('home');

//Profile Routes
Route::middleware('auth')->prefix('{locale}')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//Professional Profile Routes
Route::controller(ProfessionalProfileController::class)->prefix('{locale}')->group(function () {
    Route::get('/professional_profile/results', 'index')->name('professional_profile.index');
    Route::get('/professional_profile/create', 'create')->name('professional_profile.create');
    Route::post('/professional_profile', 'store')->name('professional_profile.store');
    Route::get('/professional_profile/{slug}', 'show')->name('professional_profile.show');
});


//FullCalendar EventController Routes
Route::get('/events', [EventController::class, 'index']
);

require __DIR__.'/auth.php';

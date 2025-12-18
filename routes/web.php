<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSearchController;
use App\Http\Controllers\ProfessionalProfileController;
use App\Http\Controllers\RegisterProfileController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

//Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//Professional Profile Routes
Route::get('professional_profile/results', [ProfessionalProfileController::class, 'index']
)->name('professional_profile.index');

Route::get('professional_profile/create', [ProfessionalProfileController::class, 'create'])
->name('professional_profile.create');

Route::post('professional_profile', [ProfessionalProfileController::class, 'store'])
->name('professional_profile.store');

Route::get('professional_profile/{slug}', [ProfessionalProfileController::class, 'show']
)->name('professional_profile.show');

//EventController Routes
Route::get('/events', [EventController::class, 'index']
);

require __DIR__.'/auth.php';

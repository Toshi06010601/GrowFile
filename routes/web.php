<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSearchController;
use App\Http\Controllers\ProfessionalProfileController;
use App\Http\Controllers\RegisterProfileController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

Route::prefix('{locale}')->get('/', function () {
    return view('welcome');
})->name('home');

//Profile Routes
Route::middleware(['auth', 'verified'])->prefix('{locale}')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//Professional Profile Routes
Route::controller(ProfessionalProfileController::class)->prefix('{locale}')->group(function () {
    Route::get('/professional_profile/results', 'index')->name('professional_profile.index');
    Route::middleware(['auth', 'verified'])->get('/professional_profile/create', 'create')->name('professional_profile.create');
    Route::middleware(['auth', 'verified'])->post('/professional_profile', 'store')->name('professional_profile.store');
    Route::get('/professional_profile/{slug}', 'show')->name('professional_profile.show');
});


//FullCalendar EventController Routes
Route::get('/api/events', [EventController::class, 'index']
);

Route::get('locale/{lang}', function ($lang) {
   if (in_array($lang, config('app.supported_locales'))) {
        session(['locale' => $lang]);
        App::setLocale($lang);

        // Save locale preference if user is authenticated
        if (Auth::check()) {
            Auth::user()->update(['locale' => $lang]);
        }
        
        // Get the previous URL
        $previousUrl = url()->previous();
        $path = parse_url($previousUrl, PHP_URL_PATH);
        $segments = explode('/', trim($path, '/'));

        // Replace the first segment (the locale) with the new lang
        if (count($segments) > 0 && in_array($segments[0], config('app.supported_locales'))) {
            $segments[0] = $lang;
            return redirect()->to(implode('/', $segments));
        }
    }
    return redirect()->back();
})->name('locale.switch');

require __DIR__.'/auth.php';

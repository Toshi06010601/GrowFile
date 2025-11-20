<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share with navigation layout
        View::composer('layouts.navigation', function ($view) {
            $userProfile = null;
            
            if (Auth::check()) {
                $userProfile = Profile::where('user_id', Auth::id())
                    ->select('slug', 'profile_image_path')
                    ->first();
            }
            
            $view->with('userProfile', $userProfile);
        });
    }
}

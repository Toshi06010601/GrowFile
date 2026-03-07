<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    public function update($lang) {
        if (in_array($lang, config('app.supported_locales'))) {
            // Save the locale to session and app
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
    }
}

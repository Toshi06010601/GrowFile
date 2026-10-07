<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

/**
 * Handles switching the application language.
 */
class LocaleController extends Controller
{
    /**
     * Switch the locale and send the user back to the page they were on.
     *
     * The locale is stored in the session and, for logged-in users, on their
     * profile. URLs are locale-prefixed (/en/...), so the first path segment of
     * the previous URL is swapped for the new language.
     *
     * @param  string  $lang  Must be listed in config('app.supported_locales'); otherwise ignored.
     */
    public function update(string $lang):RedirectResponse
     {
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

            if (!str_starts_with($previousUrl, url('/'))) {
                return redirect()->route('home'); // Safe fallback
            }
    
            // Replace the first segment (the locale) with the new lang
            if (count($segments) > 0 && in_array($segments[0], config('app.supported_locales'))) {
                $segments[0] = $lang;
                return redirect()->to(implode('/', $segments));
            }
        }
        return redirect()->back();
    }
}

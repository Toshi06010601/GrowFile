<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale')
            ?? $this->getLocaleFromReferer($request)
            ?? auth()->user()?->locale
            ?? session('locale')
            ?? config('app.locale');

        // logger()->info($request->route('locale'));

        if (!in_array($locale, config('app.supported_locales'))) {
            $locale = 'en'; // hard fallback
        }

        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);
        session(['locale' => $locale]);
                
        return $next($request);
    }

    // Helper to peek at the previous URL
    private function getLocaleFromReferer($request)
    {
        $referer = $request->header('referer');
        if (!$referer) return null;

        $path = parse_url($referer, PHP_URL_PATH);
        $segments = explode('/', trim($path, '/'));

        // If the first segment is 'en' or 'jp', use it
        return in_array($segments[0] ?? '', ['en', 'jp']) ? $segments[0] : null;
    }
}

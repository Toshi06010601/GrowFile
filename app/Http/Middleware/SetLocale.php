<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

/**
 * Resolves and applies the locale for the current request.
 *
 * The locale is taken from the first available source: the `{locale}` route
 * parameter, the referer URL, the authenticated user's preference, the
 * session, and finally the app default. Unsupported values fall back to "en".
 * The resolved locale is applied to the app, set as the default `locale`
 * URL parameter, and persisted to the session.
 */
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

        if (! in_array($locale, config('app.supported_locales'))) {
            $locale = 'en'; // hard fallback
        }

        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);
        session(['locale' => $locale]);

        return $next($request);
    }

    /**
     * Extract the locale ("en" or "jp") from the first path segment of the referer URL.
     */
    private function getLocaleFromReferer(Request $request): ?string
    {
        $referer = $request->header('referer');
        if (! $referer) {
            return null;
        }

        $path = parse_url($referer, PHP_URL_PATH);
        $segments = explode('/', trim($path ?? '', '/'));

        // If the first segment is 'en' or 'jp', use it
        return in_array($segments[0] ?? '', ['en', 'jp']) ? $segments[0] : null;
    }
}

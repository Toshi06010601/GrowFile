<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

/**
 * Rate-limits Livewire update requests per user (or IP for guests).
 *
 * Allows {@see self::MAX_ATTEMPTS} updates per {@see self::DECAY_SECONDS}
 * seconds and returns a 429 JSON response once the limit is exceeded.
 */
class ThrottleLivewireUpdates
{
    private const MAX_ATTEMPTS = 60;

    private const DECAY_SECONDS = 60;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->hasHeader('X-Livewire')) {
            return $next($request);
        }

        $key = 'livewire-global:'.($request->user()?->id ?: $request->ip());

        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            $retryAfter = RateLimiter::availableIn($key);

            return response()->json([
                'message' => "Too many requests. Please wait {$retryAfter} seconds.",
                'retry_after' => $retryAfter,
                'max_attempts' => self::MAX_ATTEMPTS,
            ], Response::HTTP_TOO_MANY_REQUESTS, [
                'Retry-After' => $retryAfter,
                'X-RateLimit-Limit' => self::MAX_ATTEMPTS,
                'X-RateLimit-Remaining' => 0,
            ]);
        }

        RateLimiter::hit($key, self::DECAY_SECONDS);

        $response = $next($request);

        $response->headers->add([
            'X-RateLimit-Limit' => self::MAX_ATTEMPTS,
            'X-RateLimit-Remaining' => RateLimiter::remaining($key, self::MAX_ATTEMPTS),
        ]);

        return $response;
    }
}

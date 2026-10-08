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
 *
 * The window is fixed, not sliding: it opens on the first request and resets
 * {@see self::DECAY_SECONDS} seconds later, regardless of later requests.
 * Counters are stored in the application cache.
 */
class ThrottleLivewireUpdates
{
    /**
     * Maximum number of Livewire updates a client may send per window.
     */
    private const MAX_ATTEMPTS = 60;

    /**
     * Length of the rate-limit window in seconds, counted from the first request.
     */
    private const DECAY_SECONDS = 60;

    /**
     * Handle an incoming request.
     *
     * Non-Livewire requests pass through untouched. Livewire requests are
     * counted against a per-client key and rejected with a 429 once the limit
     * is reached; allowed responses carry `X-RateLimit-*` headers so the
     * client can see how many requests remain.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->hasHeader('X-Livewire')) {
            return $next($request);
        }

        // One counter per logged-in user, or per IP address for guests.
        $key = 'livewire-global:'.($request->user()?->id ?: $request->ip());

        // Check if it has reached the max attempt counts within the delay window
        if (RateLimiter::tooManyAttempts($key, self::MAX_ATTEMPTS)) {
            // Seconds until the current window expires and the counter resets.
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

        // Count this request; the first hit opens a new DECAY_SECONDS window.
        RateLimiter::hit($key, self::DECAY_SECONDS);

        $response = $next($request);
        $response->headers->add([
            'X-RateLimit-Limit' => self::MAX_ATTEMPTS,
            'X-RateLimit-Remaining' => RateLimiter::remaining($key, self::MAX_ATTEMPTS),
        ]);

        return $response;
    }
}

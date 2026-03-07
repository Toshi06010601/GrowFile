<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\RateLimiter;

class ThrottleLivewireUpdates
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasHeader('X-Livewire')) {
            return $next($request);
        }

        $key = 'livewire-global:' . ($request->user()?->id ?: $request->ip());
        $maxAttempts = 10;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $retryAfter = RateLimiter::AvailableIn($key);

            return response()->json([
                'message' => "Too many requests. Please wait {$retryAfter} seconds.",
                'retry_after' => $retryAfter,
                'max-attempts' => $maxAttempts
            ], 429)->withHeaders([
                'Retry-After' => $retryAfter,
                'X-Rate-Limit' => $maxAttempts,
                'X-RateLimit-Remaining' => 0
            ]);
        }

        RateLimiter::hit($key, $maxAttempts);

        $remaining = RateLimiter::remaining($key, $maxAttempts);

        return $next($request)->withHeaders([
            'X-Rate-Limit' => $maxAttempts,
            'X-RateLimit-Remaining' => $remaining
        ]);
    }
}
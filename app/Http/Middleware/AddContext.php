<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Context;
use Symfony\Component\HttpFoundation\Response;

/**
 * Adds request-scoped context shared by every log entry.
 *
 * Records the authenticated user's ID (or "guest") and the client IP, so
 * each log line written during the request can be traced back to its source.
 */
class AddContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authId = Auth::id() ?? 'guest';

        Context::add('auth_id', $authId);
        Context::add('ip', $request->ip());

        return $next($request);
    }
}

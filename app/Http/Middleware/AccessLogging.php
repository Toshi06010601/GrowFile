<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Logs the method and URI of each incoming request.
 *
 * Livewire's background update requests are skipped, since every component
 * interaction would otherwise add a line and flood the log.
 */
class AccessLogging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

    // if (!$request->is('livewire/update')) {
    //     logger()->info(
    //         'access', [
    //             'method' => $request->method(),
    //             'uri' => $request->getRequestUri(),
    //         ]
    //     );
    // }

    // Livewire sends an X-Livewire header on its update requests.
    if (! $request->hasHeader('X-Livewire')) {
        logger()->info('access', [
            'method' => $request->method(),
            'uri' => $request->getRequestUri(),
        ]);
    }

        return $next($request);
    }
}

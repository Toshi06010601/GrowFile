<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccessLogging
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

    if (!$request->is('livewire/update')) {
        logger()->info(
            'access', [
                'method' => $request->method(),
                'uri' => $request->getRequestUri(),
            ]
        );
    }

        return $next($request);
    }
}

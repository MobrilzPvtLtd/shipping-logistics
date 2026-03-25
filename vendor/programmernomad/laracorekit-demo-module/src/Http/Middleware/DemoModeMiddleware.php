<?php

namespace LaraCoreKit\DemoModule\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DemoModeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (config('demo.enabled')) {
            $response = $next($request);
            $response->headers->set('X-Demo-Mode', 'true');

            return $response;
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ForceSSL
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->secure() && in_array(config('app.env'), ['stage', 'production'])) {
            throw new HttpException(403, 'SSL Certificate is required for this environment. Please ensure your connection is secure.');
        }

        return $next($request);
    }
}

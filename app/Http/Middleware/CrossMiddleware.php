<?php

namespace App\Http\Middleware;

use Closure;

class CrossMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Credentials', 'true')
            ->header('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, UPDATE, PATCH, DELETE')
            ->header('Access-Control-Allow-Headers', 'Content-Type, X-Session-Id, Cookie, multipart/form-data, application/json')
            ->header('Access-Control-Allow-Credentials', 'true')
            ->header('Access-Control-Allow-Origin', '');
    }
}

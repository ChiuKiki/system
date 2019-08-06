<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        $origin = $request->server('HTTP_ORIGIN') ? $request->server('HTTP_ORIGIN') : '';
        $allow_origin = ['http://localhost:8080'];

        if (in_array($origin, $allow_origin)) {
            header('Access-Control-Allow-Origin: '.$origin);
            header("Access-Control-Allow-Credentials: true");
            header("Access-Control-Allow-Methods: *");
            header("Access-Control-Allow-Headers: X-Requested-With,Content-Type,Access-Token");
            header("Access-Control-Expose-Headers: *");
        }
        return $next($request);
    }
}

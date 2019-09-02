<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class checkAdminMiddleware
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
        if(Session::get('flag') != 1){
            return response(array('message'=>'无权限！'),403);
        }
        return $next($request);
    }
}

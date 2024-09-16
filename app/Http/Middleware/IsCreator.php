<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsCreator
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
        if (\Auth::check() && \Auth::user()->user_type=="creator") {
            return $next($request);
        }
        abort(404);
  
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class AccessDBADevops
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
        if(Auth::user()->hasRole('dba') || Auth::user()->hasRole('devops')){
            return $next($request);
        }

        return redirect('home');
    }
}

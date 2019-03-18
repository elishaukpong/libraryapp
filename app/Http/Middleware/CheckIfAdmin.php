<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfAdmin
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
          if (Auth::guard($guard)->check()) {
            if (!Auth::user()->admin) {
                Session::flash('error', 'You don\'t have access rights');
                return redirect()->route('home');
            }
        }
        return $next($request);
    }
}

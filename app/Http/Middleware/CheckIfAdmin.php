<?php

namespace App\Http\Middleware;

use Auth;
use Session;
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
    public function handle($request, Closure $next, $guard = null)
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

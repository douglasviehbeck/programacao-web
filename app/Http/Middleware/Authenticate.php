<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return Redirect::guest('/');
        }

        return $next($request);
    }
}

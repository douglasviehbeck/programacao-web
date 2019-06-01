<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() && !App::runningUnitTests()) {
            abort(401);
        }

        return $next($request);
    }
}

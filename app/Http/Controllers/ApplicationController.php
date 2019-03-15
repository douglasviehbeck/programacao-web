<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ApplicationController extends Controller
{
    public function app(Request $request)
    {
        if (!Auth::check()) {
            if ($request->path() == '/') {
                return view('login');
            } else {
                return Redirect::guest('/');
            }
        }

        return view('app');
    }
}

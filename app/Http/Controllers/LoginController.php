<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $errors = [];

        if (is_null($request->username)) {
            $errors['username'] = 'null';
        }

        if (is_null($request->password)) {
            $errors['password'] = 'null';
        }

        if (!empty($errors)) {
            return Redirect::back()->withErrors($errors);
        }

        if (!Auth::attempt($request->only(['password', 'username',]))) {
            return Redirect::back()->withErrors([
                'loginError' => 'invalid'
            ]);
        }

        return redirect('/');
    }
}

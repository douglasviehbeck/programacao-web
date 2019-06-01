<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorMessageException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $errors = [];

        if (is_null($request->username)) {
            $errors['username'] = 'O campo é obrigatório';
        }

        if (is_null($request->password)) {
            $errors['password'] = 'O campo é obrigatório';
        }

        if (!empty($errors)) {
            throw new ErrorMessageException($errors);
        }

        $token = Auth::attempt($request->only(['password', 'username',]));

        if (!$token) {
            throw new ErrorMessageException([
                'loginError' => 'Usuário e/ou senha inválidos',
            ]);
        }

        return $token;
    }
}

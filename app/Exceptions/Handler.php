<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ErrorMessageException && $request->header('Vuelidation')) {
            return response()->json(array_merge([
                'Vuelidation' => [
                    'hash'     => $request->header('Vuelidation'),
                    'messages' => $exception->messages,
                ]
            ], $exception->response));
        }

        return parent::render($request, $exception);
    }
}

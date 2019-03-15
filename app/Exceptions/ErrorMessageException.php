<?php

namespace App\Exceptions;

use Exception;

class ErrorMessageException extends Exception
{
    public $messages;
    public $response;

    public function __construct(array $messages = [], $response = [])
    {
        $this->messages = $messages;
        $this->response = $response;

        parent::__construct('', 0, null);
    }
}

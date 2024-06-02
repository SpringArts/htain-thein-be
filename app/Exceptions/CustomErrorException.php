<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class CustomErrorException extends Exception
{
    protected $message;
    protected $statusCode;

    public function __construct(string $message = "An error occurred", int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($message, $statusCode);
        $this->message = $message;
        $this->statusCode = $statusCode;
    }

    public function render($request)
    {
        return response()->json([
            'error' => $this->message,
        ], $this->statusCode);
    }
}

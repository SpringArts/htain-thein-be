<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomErrorException extends Exception
{
    protected int $statusCode;

    public function __construct(string $message = 'An error occurred', int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'error' => $this->getMessage(),
        ], $this->statusCode);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}

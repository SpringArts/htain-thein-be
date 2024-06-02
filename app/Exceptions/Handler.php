<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'errors' => ['Your permission is not allowed.']
            ], Response::HTTP_FORBIDDEN);
        }

        if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                'errors' => 'No data found in the database.'
            ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json([
                'errors' => 'The requested URL was not found on this server.'
            ], Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return response()->json([
                'errors' => 'The specified method for the request is invalid.'
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return response()->json([
                'errors' => $exception->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($exception instanceof \Illuminate\Database\QueryException) {
            return response()->json([
                'errors' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
            return response()->json([
                'errors' => $exception->getMessage()
            ], $exception->getStatusCode());
        }

        if ($exception instanceof CustomErrorException) {
            return response()->json([
                'errors' => $exception->getMessage()
            ], $exception->getCode());
        }


        return parent::render($request, $exception);
    }
}

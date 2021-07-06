<?php

namespace App\Exceptions;

use App\Traits\Response;
use Error;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    use Response;

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        // AuthorizationException::class,
        // HttpException::class,
        // ModelNotFoundException::class,
        // ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            if ($exception instanceof AuthenticationException) {
                return $this->responseUnauthorized();
            }
            if ($exception instanceof AuthorizationException) {
                return $this->responseForbidden();
            }
            if ($exception instanceof ModelNotFoundException) {
                return $this->responseNotFound();
            }
            if ($exception instanceof ValidationException) {
                return $this->responseValidationErrors($exception);
            }
            if ($exception instanceof QueryException) {
                return $this->responseInternalError(
                    $exception, 
                    'There was issue with the query'
                );
            }
            if ($exception instanceof RuntimeException) {
                return $this->responseError(
                    $exception->getMessage(),
                    $exception->getCode(),
                    $exception
                );
            }
            if ($exception instanceof Error || $exception instanceof Exception) {
                return $this->responseInternalError($exception);
            }
        }

        return parent::render($request, $exception);
    }
}

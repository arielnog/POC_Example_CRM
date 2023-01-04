<?php

namespace App\Exceptions;

use App\Traits\Response;
use Error;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use Response;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @param Throwable $e
     * @return void
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * @param $request
     * @param Throwable $e
     * @return JsonResponse
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse|\Illuminate\Http\Response
    {
        if ($request->header('Content-Type') == 'application/json') {
            if ($e instanceof AuthenticationException) {
                return $this->responseUnauthorized();
            }
            if ($e instanceof AuthorizationException) {
                return $this->responseForbidden();
            }
            if ($e instanceof ModelNotFoundException) {
                return $this->responseNotFound();
            }
            if ($e instanceof ValidationException) {
                return $this->responseValidationErrors($e);
            }
            if ($e instanceof QueryException) {
                return $this->responseInternalError(
                    $e,
                    'There was issue with the query',
                    $e->getCode()
                );
            }
            if ($e instanceof RuntimeException) {
                return $this->responseError(
                    $e->getMessage(),
                    $e->getCode(),
                    $e
                );
            }
            if ($e instanceof Error || $e instanceof Exception || $e instanceof Throwable) {
                return $this->responseInternalError(
                    exception: $e,
                    code: 500
                );
            }
        }

        return parent::render($request, $e);
    }
}

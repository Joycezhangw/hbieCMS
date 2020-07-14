<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
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
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        if ($this->isHttpException($exception)) {
            $message=$exception->getMessage();
            if ($exception->getStatusCode() == 404) {
                return response()->view('errors.' . '404', compact('message'), 404);
            }
            if ($exception->getStatusCode() == 500) {
                return response()->view('errors.' . '500', compact('message'), 500);
            }
            if ($exception->getStatusCode() == 403) {
                return response()->view('errors.' . '403', compact('message'), 403);
            }
            if ($exception->getStatusCode() == 490) {
                return response()->view('errors.' . '490', compact('message'), 490);
            }
        }
        return parent::render($request, $exception);
    }
}

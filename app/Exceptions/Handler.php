<?php

namespace App\Exceptions;

use Exception, Redirect, Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }
        if ($e instanceof \App\App\Managers\ValidationException) {
            return Redirect::back()->withInput()->withErrors($e->getErrors());
        }
        if ($e instanceof \App\App\Managers\SaveDataException) {
            Session::flash('error', $e->getException()->getMessage());
            return Redirect::back()->withInput()->withErrors($e->getException()->getMessage());
        }
        if ($e instanceof \Illuminate\Database\QueryException) {
            Session::flash('error', $e->getMessage());
            return Redirect::back()->withInput()->withErrors($e->getMessage());
        }
        

        return parent::render($request, $e);
    }
}

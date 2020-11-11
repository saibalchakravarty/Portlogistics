<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use \Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Throwable;

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
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        /*if ($exception instanceof NotFoundHttpException) {
            // ajax 404 json feedback
            if ($request->ajax()) {
                return response()->json(['error' => 'Not Found'], 404);
            }         
        }

        // normal 404 view page feedback
        if ($this->isHttpException($exception)) {
            if ($exception->getStatusCode() == 404) {
                return response()->view('errors.404', [], 404);
            }
        } */
        /* if($exception instanceof \ErrorException)
        {
                return response()->view('errors.404', [], 404);
        }
        if($exception instanceof BindingResolutionException)
        {
                return response()->view('errors.404', [], 404);
        } */
      /*   if($exception->getMessage() == 'Unauthenticated.'){
             return redirect()->away(url('login'));
         }*/
    /*    if (config('app.debug') && !$this->isHttpException($exception)) {
            $exception = new HttpException(500);
        }*/
        if ($exception instanceof \Illuminate\Session\TokenMismatchException) {
            $request->session()->flush();
            return redirect()->route('login');
        }
        return parent::render($request, $exception);
    }
}

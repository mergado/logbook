<?php

namespace App\Exceptions;

use App\Auth;
use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Session;
use MergadoClient\Exception\UnauthorizedException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Process\Exception\InvalidArgumentException;

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
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {

        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        $isWidget = preg_match("/\b^widget\b/", $request->path());

        if ($isWidget) {
            return redirect()->route('errors.widget');
        }

        if ($e instanceof UnauthorizedException) {
            $routeId = $request->route()->parameter('eshop_id');
            $auth = new Auth();
            Session::put('next', $request->url());
            return $auth->getAuthCode($routeId);
        } elseif ($e instanceof NotFoundHttpException) {
            return response()->view('errors.404', ['errors' => []])->setStatusCode(404);
        } elseif ($e instanceof InvalidArgumentException) {
            return redirect()->route('404');
        } elseif ($e instanceof ClientException) {
            return redirect()->route('404');
        } elseif ($e instanceof FatalThrowableError) {
            return redirect()->route('error', ['message' => trans('error.authorization')]);
        } elseif ($e instanceof AuthorizationException) {
            return redirect()->route('error', ['message' => $e->getMessage()]);
        }

        if (app()->environment() == 'production') {
            return redirect()->route('error');

        }

        return parent::render($request, $e);
    }
}

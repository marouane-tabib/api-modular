<?php

use App\Exceptions\GeneralExceptionHandler;
use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Spatie\HttpLogger\Middlewares\HttpLogger;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            ForceJsonResponse::class,
            HttpLogger::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $generalExceptionHandler = new GeneralExceptionHandler();

        $exceptions->dontReport($generalExceptionHandler->dontReport());
        $exceptions->dontFlash($generalExceptionHandler->dontFlash());
        $exceptions->reportable(function (Throwable $exception) use ($generalExceptionHandler) {
            $generalExceptionHandler->reportable($exception);
        });
        $exceptions->render(function (Throwable $e, Request $request) use ($generalExceptionHandler) {
            return $generalExceptionHandler->render($e, $request);
        });
    })->create();

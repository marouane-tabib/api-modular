<?php

use App\Exceptions\GeneralExceptionHandler;
use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\ForceSSL;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Spatie\HttpLogger\Middlewares\HttpLogger;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([
            ForceJsonResponse::class,
            HttpLogger::class,
            ForceSSL::class
        ]);
        $middleware->alias([
            'permission' => PermissionMiddleware::class,
            'role'       => RoleMiddleware::class,
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

<?php

use App\Http\Middleware\ForceJsonResponse;
use App\Services\ResponderService\ResponderService;
use Flugg\Responder\Responder;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

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
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->wantsJson()) {
                return responder()->error(message: "An unexpected error occurred. Please try again later.")->data([
                    "errors"  => config('app.rest_debug') && isset($e) ? [
                        "exception" => (new ReflectionClass($e))->getShortName(),
                        "message"   => $e->getMessage(),
                        "file"      => $e->getFile(),
                        "line"      => $e->getLine(),
                        "code"      => $e->getCode(),
                    ]: true
                ])->respond();
            }
        });
    })->create();

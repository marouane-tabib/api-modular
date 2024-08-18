<?php

use App\Http\Middleware\ForceJsonResponse;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
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
        $exceptions->dontReport([
            \Illuminate\Auth\AuthenticationException::class,
            \Illuminate\Auth\Access\AuthorizationException::class,
            \Symfony\Component\HttpKernel\Exception\HttpException::class,
            \Illuminate\Database\Eloquent\ModelNotFoundException::class,
            \Illuminate\Session\TokenMismatchException::class,
            \Illuminate\Validation\ValidationException::class,
        ]);
        $exceptions->dontFlash([
            'password',
            'password_confirmation',
            'current_password',
        ]);
        $exceptions->reportable(function (Throwable $exception) {
            Bugsnag::notifyException($exception, function ($report) use ($exception) {
                if ($exception instanceof Exception) {
                    $throwableType = 'warning';
                } elseif ($exception instanceof Error) {
                    $throwableType = 'error';
                }
                $request = new Request();
                $report->setMetaData([  
                    'timestamp' => gmdate('c'),
                    'exception' => [
                        'severity_level' => isset($throwableType)? $report->setSeverity($throwableType): null,
                        'exception' => (new ReflectionClass($exception))->getShortName(),
                        'message' => $exception->getMessage(),
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                        'code' => $exception->getCode(),
                    ],
                ]);
                $report->setMetaData([
                    'request' => [
                        'url' => $request->fullUrl(),
                        'method' => $request->method(),
                        'headers' => request()->except(['authorization', 'cookie', 'password', 'password_confirmation', 'current_password']),
                        'body' => request()->except(['password', 'password_confirmation', 'current_password']),

                        'query' => $request->query(),
                        'from' => $request->query('from', 'N/A'),
                        'to' => $request->query('to', 'N/A'),
                        'user_agent' => $request->header('User-Agent'),
                        'ip_address' => $request->ip(),
                    ],
                ]);
                $report->setMetaData([
                    'server' => [
                        'php_version' => phpversion(),
                        'software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
                        'environment' => app()->environment(),
                        'hostname' => gethostname(),
                        'server_ip' => $request->server('SERVER_ADDR', '127.0.0.1'),
                        'port' => $request->server('SERVER_PORT', '80'),
                        'device_name' => php_uname('n')
                    ]
                ]);
                $report->setMetaData([
                    'user' => [
                        'id' => auth()->check() ? auth()->id() : 'N/A',
                        'name' => auth()->check() ? auth()->user()->name : 'N/A',
                        'email' => auth()->check() ? auth()->user()->email : 'N/A',
                    ]
                ]);
            });
        });
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

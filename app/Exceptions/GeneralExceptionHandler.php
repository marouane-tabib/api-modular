<?php namespace App\Exceptions;

use App\Logging\CustomLogChannel;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Error;
use Exception;
use Illuminate\Http\Request;
use ReflectionClass;
use Throwable;

class GeneralExceptionHandler
{
    public function dontReport()
    {
        return [
            \Illuminate\Auth\AuthenticationException::class,
            \Illuminate\Auth\Access\AuthorizationException::class,
            \Symfony\Component\HttpKernel\Exception\HttpException::class,
            \Illuminate\Database\Eloquent\ModelNotFoundException::class,
            \Illuminate\Session\TokenMismatchException::class,
            \Illuminate\Validation\ValidationException::class,
        ];
    }

    public function dontFlash()
    {
        return [
            'password',
            'password_confirmation',
            'current_password',
        ];
    }

    public function reportable(Throwable $exception)
    {
        Bugsnag::notifyException($exception, function ($report) use ($exception) {
            if ($exception instanceof Exception) {
                $throwableType = 'warning';
            } elseif ($exception instanceof Error) {
                $throwableType = 'error';
            }
            
            $report->setMetaData(CustomLogChannel::processors());
            $report->setMetaData([  
                'timestamp' => gmdate('c'),
                'exception' => [
                    'severity_level' => isset($throwableType) ? $report->setSeverity($throwableType) : null,
                    'exception' => (new ReflectionClass($exception))->getShortName(),
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'code' => $exception->getCode(),
                ],
            ]);
        });
    }

    public function render(Throwable $e, Request $request)
    {   
        if ($request->wantsJson()) {
            return responder()->error(message: "An unexpected error occurred. Please try again later.")->data([
                "errors" => config('app.rest_debug') && isset($e) ? [
                    "exception" => (new ReflectionClass($e))->getShortName(),
                    "message"   => $e->getMessage(),
                    "file"      => $e->getFile(),
                    "line"      => $e->getLine(),
                    "code"      => $e->getCode(),
                ] : true,
            ])->respond();
        }
    }
}

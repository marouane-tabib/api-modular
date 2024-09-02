<?php

namespace App\Exceptions;

use App\Logging\CustomLogChannel;
use App\Logging\Processors\ContextExceptionProcessor;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Error;
use Exception;
use Illuminate\Http\Request;
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
            $throwableType = null;
            if ($exception instanceof Exception) {
                $throwableType = 'warning';
            } elseif ($exception instanceof Error) {
                $throwableType = 'error';
            }

            isset($throwableType) ?? $report->setSeverity($throwableType);
            $report->setMetaData(CustomLogChannel::processors());
            $report->setMetaData([
                'timestamp' => gmdate('c'),
                'severity_level' => $throwableType,
                'exception' =>  $this->exceptionProcessor($exception)
            ]);
        });
    }

    public function render(Throwable $throwable, Request $request)
    {
        if ($request->wantsJson()) {
            return responder()->error(message: "An unexpected error occurred. Please try again later.")->data([
                "exception" => config('app.rest_debug') ? $this->exceptionProcessor($throwable) : true,
            ])->respond();
        }
    }

    public function exceptionProcessor(Throwable $throwable)
    {
        if (isset($throwable)) {
            return (new ContextExceptionProcessor())($throwable);
        }
    }
}

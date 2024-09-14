<?php

namespace App\Exceptions;

use App\Logging\CustomLogChannel;
use App\Logging\Processors\ContextExceptionProcessor;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class GeneralExceptionHandler
{
    /**
     * The list of exception types that should not be reported.
     *
     * @return array
     */
    public function dontReport(): array
    {
        return [
            \Illuminate\Auth\AuthenticationException::class,
            \Illuminate\Auth\Access\AuthorizationException::class,
            \Symfony\Component\HttpKernel\Exception\HttpException::class,
            \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
            \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException::class,
            \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException::class,
            \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException::class,
            \Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException::class,
            \Illuminate\Database\Eloquent\ModelNotFoundException::class,
            \Illuminate\Validation\ValidationException::class,
            \Illuminate\Session\TokenMismatchException::class,
            \Illuminate\Http\Exceptions\ThrottleRequestsException::class,
            \Illuminate\Routing\Exceptions\UrlGenerationException::class,
            \Tymon\JWTAuth\Exceptions\TokenExpiredException::class,
            \Tymon\JWTAuth\Exceptions\TokenInvalidException::class,
            \Tymon\JWTAuth\Exceptions\TokenBlacklistedException::class,
            \Tymon\JWTAuth\Exceptions\JWTException::class,
        ];
    }

    /**
     * The attributes that should not be flashed to the session on validation errors.
     *
     * @return array
     */
    public function dontFlash(): array
    {
        return [
            'password',
            'password_confirmation',
            'current_password',
        ];
    }

    /**
     * Report the exception to Bugsnag.
     *
     * @param Throwable $exception
     * @return void
     */
    public function reportable(Throwable $exception): void
    {
        Bugsnag::notifyException($exception, function ($report) use ($exception) {
            $severity = ($exception instanceof Error) ? 'error' : 'warning';
            $report->setSeverity($severity);
            $report->setMetaData(CustomLogChannel::processors());
            $report->setMetaData([
                'timestamp' => gmdate('c'),
                'severity_level' => $severity,
                'exception' => $this->processException($exception),
            ]);
        });
    }

    /**
     * Render the exception response.
     *
     * @param Throwable $throwable
     * @param Request $request
     * @return mixed
     */
    public function render(Throwable $throwable, Request $request)
    {
        if ($request->wantsJson()) {
            return $this->handleJsonException($throwable);
        }
    }

    /**
     * Handle JSON exceptions.
     *
     * @param Throwable $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleJsonException(Throwable $exception): \Illuminate\Http\JsonResponse
    {
        switch (true) {
            case $exception instanceof \Illuminate\Auth\AuthenticationException:
                return $this->errorResponse(401, 'Unauthenticated.');

            case $exception instanceof \Illuminate\Auth\Access\AuthorizationException:
                return $this->errorResponse(403, 'Unauthorized.');

            case $exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException:
                return $this->errorResponse(404, 'Resource not found.');

            case $exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException:
                return $this->errorResponse(405, 'Method not allowed.');

            case $exception instanceof \Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException:
                return $this->errorResponse(422, 'Unprocessable entity.');

            case $exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException:
                return $this->errorResponse(404, 'Model not found.');

            case $exception instanceof \Illuminate\Validation\ValidationException:
                return $this->errorResponse(422, 'Validation error.', ['errors' => $exception->errors()]);

            case $exception instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException:
                return $this->errorResponse(401, 'Token has expired.');

            case $exception instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException:
                return $this->errorResponse(401, 'Token is invalid.');

            case $exception instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException:
                return $this->errorResponse(401, 'Token has been blacklisted.');

            case $exception instanceof \Tymon\JWTAuth\Exceptions\JWTException:
                return $this->errorResponse(500, 'JWT error.');

            default:
                return $this->errorResponse(500, 'An unexpected error occurred. Please try again later.', [
                    'exception' => config('app.rest_debug') ? $this->processException($exception) : true,
                ]);
        }
    }

    /**
     * Return a structured error response.
     *
     * @param int $statusCode
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse(int $statusCode, string $message, array $data = []): JsonResponse
    {
        return responder()->error(message: $message)->data($data)->respond($statusCode);
    }

    /**
     * Process the exception for additional context.
     *
     * @param Throwable $exception
     * @return mixed
     */
    protected function processException(Throwable $exception)
    {
        return isset($exception) ? (new ContextExceptionProcessor())($exception) : null;
    }
}

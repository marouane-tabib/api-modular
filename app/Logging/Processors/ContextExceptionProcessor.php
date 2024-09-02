<?php

namespace App\Logging\Processors;

use ReflectionClass;
use Throwable;

class ContextExceptionProcessor
{
    public function __invoke(Throwable $throwable)
    {
        return [
            "exception" => (new ReflectionClass($throwable))->getShortName(),
            "message"   => $throwable->getMessage(),
            "file"      => $throwable->getFile(),
            "line"      => $throwable->getLine(),
            "code"      => $throwable->getCode(),
        ];
    }
}

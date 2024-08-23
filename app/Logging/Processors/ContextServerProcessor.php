<?php

namespace App\Logging\Processors;

class ContextServerProcessor 
{
    public function __invoke()
    {
        return [
            'php_version' => phpversion(),
            'software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
            'environment' => app()->environment(),
            'hostname' => gethostname(),
            'server_ip' => request()->server('SERVER_ADDR', '127.0.0.1'),
            'port' => request()->server('SERVER_PORT', '80'),
            'device_name' => php_uname('n')
        ];
    }
}
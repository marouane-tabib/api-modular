<?php

namespace App\Logging;

use Illuminate\Support\Facades\File;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\JsonFormatter;
use Psr\Log\LogLevel;

class CustomLogChannel
{
    public function __invoke(array $config)
    {
        $log = new Logger('custom_json');

        $path = $this->getLogPath();
        $handler = new StreamHandler($path, $this->getLogLevel());
        $handler->setFormatter($this->getFormatter());

        foreach ($this->getProcessors() as $processor) {
            $log->pushProcessor($processor);
        }

        $log->pushHandler($handler);

        return $log;
    }

    protected function getLogPath()
    {
        $baseDir = storage_path('logs/error/' .date('Y-m'). '//general/');
        if (!File::exists($baseDir)) {
            File::makeDirectory($baseDir, 0777, true);
        }
        
        return $baseDir . '/' . date('Y-m-d') . '.log';
    }

    protected function getLogLevel()
    {
        return LogLevel::ERROR;
    }

    protected function getFormatter()
    {
        return new JsonFormatter();
    }

    protected function getProcessors()
    {
        $extra = [
            'timestamp' => gmdate('c'),
            'request' => [
                'url' => request()->fullUrl(),
                'method' => request()->method(),
                'headers' => request()->except(['authorization', 'cookie', 'password', 'password_confirmation', 'current_password']),
                'body' => request()->except(['password', 'password_confirmation', 'current_password']),
                'query' => request()->query(),
                'from' => request()->query('from', 'N/A'),
                'to' => request()->query('to', 'N/A'),
                'user_agent' => request()->header('User-Agent'),
                'ip_address' => request()->ip(),
            ],
            
            'server' => [
                'php_version' => phpversion(),
                'software' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
                'environment' => app()->environment(),
                'hostname' => gethostname(),
                'server_ip' => request()->server('SERVER_ADDR', '127.0.0.1'),
                'port' => request()->server('SERVER_PORT', '80'),
                'device_name' => php_uname('n')
            ],

            'user' => [
                'id' => auth()->check() ? auth()->id() : 'N/A',
                'name' => auth()->check() ? auth()->user()->name : 'N/A',
                'email' => auth()->check() ? auth()->user()->email : 'N/A',
            ],
            
            'meta_data' => [
                'release_version' => getReleaseVersion(),
                'commit_hash' => getCommitHash(),
                'commit_author' => getCommitAuthor(),
                'commit_date' => getCommitDate(),
                'author' => getAuthor(),
            ]
        ];

        return [
            function ($record) use ($extra) {
                $record['extra'] = $extra;
                return $record;
            },
        ];
    }
}

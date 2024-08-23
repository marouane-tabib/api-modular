<?php

namespace App\Logging;

use App\Logging\Processors;
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
        $extra = self::processors();

        return [
            function ($record) use ($extra) {
                $record['extra'] = $extra;
                return $record;
            },
        ];
    }

    public static function processors()
    {
        return [
            'timestamp' => gmdate('c'),
            'request' => (new Processors\ContextRequestProcessor())(),
            'server' => (new Processors\ContextServerProcessor())(),
            'user' => (new Processors\ContextUserProcessor())(),
            'meta_data' => (new Processors\ContextVersionProcessor())()
        ];
    }
}

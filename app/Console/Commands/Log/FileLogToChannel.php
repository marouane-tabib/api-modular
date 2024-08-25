<?php

namespace App\Console\Commands\Log;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class FileLogToChannel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:file-log-to-channel {file_path} {channel} {severity_level=info} {--message=""}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send file logs to a specified log channel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file_path');
        $channel = $this->argument('channel');
        $severityLevel = $this->argument('severity_level');
        $message = $this->option('message');

        if (File::exists($filePath)) {
            $logs = File::get($filePath);
            $logs = json_decode($logs, true);

            if ($logs === null) {
                $this->error("Invalid JSON in log file: $filePath");
                return 1;
            }

            foreach ($logs as $log) {
                if (!is_array($log)) {
                    $log = (array) $log;
                }

                if (method_exists(Log::channel($channel), $severityLevel)) {
                    Log::channel($channel)->$severityLevel($message, $log);
                } else {
                    $this->error("Invalid severity level: $severityLevel");
                    return 1;
                }
            }

            $this->info("Logs have been sent to $channel successfully.");
        } else {
            $this->error("Log file not found: $filePath");
            return 1;
        }
        
        return 0;
    }
}

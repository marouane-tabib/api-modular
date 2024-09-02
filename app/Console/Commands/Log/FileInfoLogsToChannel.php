<?php

namespace App\Console\Commands\Log;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class FileInfoLogsToChannel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:info-to-channel {infoDirectory} {channel}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily logs to Channel';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = Carbon::yesterday();

        $infoDirectory = $this->argument('infoDirectory');
        $logChannel = $this->argument('channel');
        $severityLevel = 'info';
        $message = 'Info daily logs';

        $logFilePath = storage_path('logs/info/' . $date->format('Y-m') . '/'. $infoDirectory .'/' . $date->format('Y-m-d') . '.log');

        if (!file_exists($logFilePath)) {
            $this->error("Log file not found: $logFilePath");
            return 1;
        }

        Artisan::call('logs:file-log-to-channel', [
            'file_path' => $logFilePath,
            'channel' => $logChannel,
            'severity_level' => $severityLevel,
            '--message' => $message,
        ]);

        $this->info("Logs from $logFilePath have been sent to Elasticsearch successfully.");

        return 0;
    }
}

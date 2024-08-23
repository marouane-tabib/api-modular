<?php

namespace App\Console\Commands\Log;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SendLogsToElasticsearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:send-to-elasticsearch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily logs to Elasticsearch';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    
     public function handle()
     {
         $date = Carbon::today();
         $logFilePath = storage_path('logs/info/' . $date->format('Y-m') . '/http_requests/' . $date->format('Y-m-d') . '.log');
 
         if (File::exists($logFilePath)) {
            $logs = File::get($logFilePath);
            $logs = json_decode($logs);
            
            foreach ($logs as $log) {
                Log::channel('elasticsearch')->info("daily logs", [$log]);
            }
            $this->info('Logs have been sent to Elasticsearch successfully.');
         } else {
            $this->info("Log file not found: $logFilePath");
         }
     }
}

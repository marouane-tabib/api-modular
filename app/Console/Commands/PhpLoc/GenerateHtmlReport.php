<?php

namespace App\Console\Commands\PhpLoc;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class GenerateHtmlReport extends Command
{
    protected $signature = 'report:generate';
    protected $description = 'Generate an HTML report for code metrics with a timestamped filename';

    public function handle()    
    {
        $timestamp = now()->format('Y_m_d_His');
        $reportFileName = "reports/html/{$timestamp}_report";

        $directory = base_path('./app');
        $process = new Process(['phpmetrics', '--report-html=' . $reportFileName, $directory]);

        try {
            $process->mustRun();
            $this->info("Report generated: $reportFileName");
        } catch (ProcessFailedException $exception) {
            $this->error('Error: ' . $exception->getMessage());
            return 1;
        }

        return 0;
    }
}
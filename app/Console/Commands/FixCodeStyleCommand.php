<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class FixCodeStyleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code:fix {--path= : The path to run PHP CS Fixer on}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run PHP CS Fixer to fix code style issues';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = $this->option('path') ?: base_path();

        $phpCsFixer = (DIRECTORY_SEPARATOR === '\\') ? 'vendor\\bin\\php-cs-fixer.bat' : './vendor/bin/php-cs-fixer';

        $command = [$phpCsFixer, 'fix', '--config=config/php-cs-fixer.php', '--allow-risky=yes', $path];

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $this->info($process->getOutput());

        return 0;
    }
}

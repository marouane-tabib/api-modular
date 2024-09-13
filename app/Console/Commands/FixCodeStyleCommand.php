<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class FixCodeStyleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:code-style';

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
        // Define the command
        $command = './vendor/bin/php-cs-fixer fix --config=config/php-cs-fixer.php --allow-risky=yes';

        // Execute the command
        $process = Process::fromShellCommandline($command);

        // Run the process
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                $this->error($buffer);
            } else {
                $this->info($buffer);
            }
        });

        return 0;
    }
}

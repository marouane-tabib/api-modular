<?php

namespace App\Console\Commands\Module;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ModuleSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:setup {name*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up a new module by creating its repository, service, model, factory, migration, and request classes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $names = $this->argument('name');

        foreach ($names as $name) {
            Artisan::call('module:make', ['name' => [$name]]);
            Artisan::call('module:make-repository', ['name' => $name.'Repository', 'module' => $name]);
            Artisan::call('module:make-service', ['name' => $name.'Service', 'module' => $name]);
            Artisan::call('module:make-model', ['model' => $name, 'module' => $name]);
            Artisan::call('module:make-factory', ['name' => $name, 'module' => $name]);
            Artisan::call('module:make-migration', ['name' => 'create_'.Str::plural(strtolower($name)).'_table', 'module' => $name]);
            Artisan::call('module:make-request', ['name' => $name.'StoreRequest', 'module' => $name]);
            Artisan::call('module:make-request', ['name' => $name.'UpdateRequest', 'module' => $name]);

            $this->info($name . ' Module Created Successfully!');
        }
    }
}

<?php

namespace App\Console\Commands\Scribe;

use Illuminate\Console\Command;
use Knuckles\Scribe\Commands\GenerateDocumentation as CommandsGenerateDocumentation;

class GenerateDocumentation extends CommandsGenerateDocumentation
{
    protected $signature = "docs:refresh
                            {--force : Discard any changes you've made to the YAML or Markdown files}
                            {--no-extraction : Skip extraction of route and API info and just transform the YAML and Markdown files into HTML}
                            {--no-upgrade-check : Skip checking for config file upgrades. Won't make things faster, but can be helpful if the command is buggy}
                            {--config=scribe : Choose which config file to use}
                            {--scribe-dir= : Specify the directory where Scribe stores its intermediate output and cache. Defaults to `.<config_file>`}
    ";
}

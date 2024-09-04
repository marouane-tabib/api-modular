<?php

namespace App\Console\Commands\Module;

use Nwidart\Modules\Commands\Make\RepositoryMakeCommand as MakeRepositoryMakeCommand;
use Nwidart\Modules\Support\Stub;

class RepositoryMakeCommand extends MakeRepositoryMakeCommand
{
    protected function getTemplateContents(): string
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());

        return (new Stub($this->getStubName(), [
            'STUDLY_NAME' => $module->getStudlyName(),
            'CLASS_NAMESPACE' => $this->getClassNamespace($module),
            'CLASS' => $this->getClassNameWithoutNamespace(),
        ]))->render();
    }

    private function getClassNameWithoutNamespace(): array|string
    {
        return class_basename($this->getRepositoryName());
    }
}

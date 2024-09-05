<?php

namespace App\Console\Commands\Module;

use Nwidart\Modules\Commands\Make\ServiceMakeCommand as MakeServiceMakeCommand;
use Nwidart\Modules\Support\Stub;

class ServiceMakeCommand extends MakeServiceMakeCommand
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
        return class_basename($this->getServiceName());
    }
}

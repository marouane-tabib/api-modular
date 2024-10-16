<?php

namespace App\Console\Commands\Module;

use Nwidart\Modules\Commands\Make\ServiceMakeCommand as MakeServiceMakeCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;

class ServiceMakeCommand extends MakeServiceMakeCommand
{
    protected function getTemplateContents(): string
    {
        $module = $this->laravel['modules']->findOrFail($this->getModuleName());
        $classNamespace = $this->getClassNamespace($module);
        
        if ($this->option('invokable') === true) {
            $classNamespace = $this->getClassNamespace($module).'\Invokables';
        }

        return (new Stub($this->getStubName(), [
            'STUDLY_NAME'     => $module->getStudlyName(),
            'CLASS_NAMESPACE' => $classNamespace,
            'CLASS'           => $this->getClassNameWithoutNamespace(),
        ]))->render();
    }

    private function getClassNameWithoutNamespace(): array|string
    {
        return class_basename($this->getServiceName());
    }

    public function getDestinationFilePath(): string
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $filePath = GenerateConfigReader::read('services')->getPath() ?? config('modules.paths.app_folder').'Services';

        if ($this->option('invokable') === true) {
            $filePath .= '/Invokables';
        }

        return $path.$filePath.'/'.$this->getServiceName().'.php';
    }
}

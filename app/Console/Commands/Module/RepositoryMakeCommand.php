<?php

namespace App\Console\Commands\Module;

use Nwidart\Modules\Commands\Make\RepositoryMakeCommand as MakeRepositoryMakeCommand;
use Nwidart\Modules\Support\Config\GenerateConfigReader;
use Nwidart\Modules\Support\Stub;

class RepositoryMakeCommand extends MakeRepositoryMakeCommand
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

    public function getDestinationFilePath(): string
    {
        $path = $this->laravel['modules']->getModulePath($this->getModuleName());

        $filePath = GenerateConfigReader::read('repository')->getPath() ?? config('modules.paths.app_folder').'Repositories';

        if ($this->option('invokable') === true) {
            $filePath .= '/Invokables';
        }

        return $path.$filePath.'/'.$this->getRepositoryName().'.php';
    }

    private function getClassNameWithoutNamespace(): array|string
    {
        return class_basename($this->getRepositoryName());
    }
}

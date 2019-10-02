<?php

namespace Sikhlana\Modular\Console;

use Illuminate\Foundation\Console\ModelMakeCommand as BaseCommand;
use Illuminate\Support\Str;

class ModelMakeCommand extends BaseCommand
{
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\'.trim(config('modular.namespaces.models'), '\\');
    }

    protected function createMigration()
    {
        $class = substr(
            $this->qualifyClass($this->getNameInput()), strlen(
                $this->getDefaultNamespace(trim($this->rootNamespace(), '\\'))
            )
        );

        $table = str_replace('\\', '', $class);

        if (! $this->option('pivot')) {
            $table = Str::pluralStudly($table);
        }

        $table = Str::snake($table);

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    protected function createController()
    {
        $controller = substr(
            $this->qualifyClass($this->getNameInput()), strlen(
                $this->getDefaultNamespace(trim($this->rootNamespace(), '\\'))
            )
        );

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('make:controller', [
            'name' => "{$controller}Controller",
            '--model' => $this->option('resource') ? $modelName : null,
        ]);
    }

    protected function getStub()
    {
        if ($this->option('pivot')) {
            return __DIR__.'/stubs/pivot.model.stub';
        }

        return __DIR__.'/stubs/model.stub';
    }
}

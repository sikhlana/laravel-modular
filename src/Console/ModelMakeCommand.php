<?php

namespace Sikhlana\Modular\Console;

use Illuminate\Foundation\Console\ModelMakeCommand as BaseCommand;
use Illuminate\Support\Str;

class ModelMakeCommand extends BaseCommand
{
    protected function rootNamespace()
    {
        return config('modular.models.namespace');
    }

    protected function createMigration()
    {
        $class = substr(
            $this->qualifyClass($this->getNameInput()), strlen(
                $this->rootNamespace()
            )
        );

        $table = Str::snake(Str::pluralStudly(
            str_replace('\\', '', $class)
        ));

        if ($this->option('pivot')) {
            $table = Str::singular($table);
        }

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
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

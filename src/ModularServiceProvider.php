<?php

namespace Sikhlana\Modular;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Sikhlana\Modular\Console\ModelMakeCommand;

class ModularServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'../config/modular.php' => config_path('modular.php')
        ], 'config');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->extend('command.model.make', function ($command, Container $app) {
            return $app->make(ModelMakeCommand::class);
        });
    }
}

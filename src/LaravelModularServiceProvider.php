<?php

namespace Lazerg\LaravelModular;

use Illuminate\Support\ServiceProvider;
use Lazerg\LaravelModular\Commands\Frontend\TranslationsGeneratorCommand;
use Lazerg\LaravelModular\Services\FactoryLoader;
use Lazerg\LaravelModular\Services\ModulePath;

/**
 * @class LaravelModularServiceProvider
 * @package Lazerg\LaravelModular
 */
class LaravelModularServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {

    }

    /**
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot(): void
    {
        $this->app->bind(Modular::class, fn() => new Modular());
        $this->app->bind(ModulePath::class, fn() => new ModulePath());
        $this->app->make(FactoryLoader::class)->load();

        $this->commands([
            TranslationsGeneratorCommand::class,
        ]);
    }
}
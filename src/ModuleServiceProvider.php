<?php

namespace Lazerg\LaravelModular;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Lazerg\LaravelModular\Loaders\Loaders;
use Lazerg\LaravelModular\Facades\Modular;

/**
 * @class ModuleServiceProvider
 * @package Lazerg\LaravelModular
 */
class ModuleServiceProvider extends ServiceProvider
{
    use Loaders;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $path;

    /**
     * @param $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->name = Str::before(class_basename($this), 'ServiceProvider');
        $this->path = Modular::modulesPath($this->name);
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        Modular::addModule($this->name);

        $this->loadCommands();
        $this->loadEvents();
        $this->loadObservers();
        $this->loadPolicies();
        $this->loadConfigs();
        $this->loadMigrations();
        $this->loadRoutes();
        $this->loadTranslations();
        $this->loadViews();
    }
}
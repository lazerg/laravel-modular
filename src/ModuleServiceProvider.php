<?php

namespace Lazerg\LaravelModular;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Lazerg\LaravelModular\Loaders\Loaders;

/**
 * @class ModuleServiceProvider
 * @package Lazerg\LaravelModular
 */
class ModuleServiceProvider extends ServiceProvider
{
    use Loaders;

    /**
     * @var \Lazerg\LaravelModular\Modular
     */
    private Modular $modular;

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
        $this->path = modules_path($this->name);
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->modular = $this->app->make(Modular::class);
        $this->modular->addModule($this->name);

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
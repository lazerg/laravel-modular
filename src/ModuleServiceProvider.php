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
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $path;

    /**
     * @var array
     */
    protected array $commands = [];

    /**
     * @var array
     */
    protected array $events = [];

    /**
     * @var array
     */
    protected array $observers = [];

    /**
     * @var array
     */
    protected array $policies = [];

    /**
     * @var bool
     */
    protected bool $disableRoutePluralization = false;

    /**
     * @var bool
     */
    protected bool $disableWebRoutePrefix = false;

    /**
     * @var bool
     */
    protected bool $mustBeAuthenticated = true;

    /**
     * @var bool
     */
    protected bool $mustBeGuest = false;

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->name = $this->getModuleName();
        $this->path = $this->getModulePath();

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

    /**
     * @return string
     */
    protected function getModuleName(): string
    {
        return Str::before(class_basename($this), 'ServiceProvider');
    }

    /**
     * @return string
     */
    protected function getModulePath(): string
    {
        return modules_path($this->getModuleName());
    }
}
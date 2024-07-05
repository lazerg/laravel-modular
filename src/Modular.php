<?php

namespace Lazerg\LaravelModular;

use Illuminate\Support\Collection;

/**
 * @class Modular
 * @package Lazerg\LaravelModular
 */
class Modular
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $modules;

    /**
     * Modular constructor.
     */
    public function __construct()
    {
        $this->modules = collect();
    }

    /**
     * @param string $module
     * @return void
     */
    public function addModule(string $module): void
    {
        $this->modules->add($module);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    /**
     * @param string $path
     * @return string
     */
    public function modulesPath(string $path = ''): string
    {
        return base_path('modules/' . $path);
    }

    /**
     * @param string $path
     * @return \Illuminate\Support\Collection
     */
    public function getModuleClasses(string $path): Collection
    {
        return $this
            ->modules
            ->map(fn(string $module) => "Modules\\$module\\$path")
            ->filter(fn(string $class) => class_exists($class))
            ->values();
    }
}
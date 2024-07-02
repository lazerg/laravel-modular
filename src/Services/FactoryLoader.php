<?php

namespace Lazerg\LaravelModular\Services;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @class FactoryLoader
 * @package Lazerg\LaravelModular\Services
 */
class FactoryLoader
{
    /**
     * @return void
     */
    public function load(): void
    {
        Factory::guessFactoryNamesUsing(fn(string $modelName) => $this->guessFactoryNamesUsing($modelName));
        Factory::guessModelNamesUsing(fn(Factory $factory) => $this->guessModelNamesUsing($factory));
    }

    /**
     * @param string $modelName
     * @return string
     */
    protected function guessFactoryNamesUsing(string $modelName): string
    {
        $modelName = explode('\\', $modelName);

        $moduleName = $modelName[1];
        $modelName  = $modelName[3];

        return "Modules\\$moduleName\\Factories\\{$modelName}Factory";
    }

    /**
     * @param \Illuminate\Database\Eloquent\Factories\Factory $factory
     * @return string
     */
    protected function guessModelNamesUsing(Factory $factory): string
    {
        $modelName = explode('\\', get_class($factory));

        $moduleName = $modelName[1];
        $modelName  = Str::before($modelName[3], 'Factory');

        return "Modules\\$moduleName\\Models\\$modelName";
    }
}
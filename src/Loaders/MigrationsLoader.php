<?php

namespace Lazerg\LaravelModular\Loaders;

/**
 * @class MigrationsLoader
 * @package Lazerg\LaravelModular\Loaders
 */
trait MigrationsLoader
{
    /**
     * @return void
     */
    protected function loadMigrations(): void
    {
        $this->loadMigrationsFrom($this->path . '/database/migrations');
    }
}
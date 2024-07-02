<?php

namespace Lazerg\LaravelModular\Loaders;

/**
 * @class CommandsLoader
 * @package Lazerg\LaravelModular\Loaders
 */
trait CommandsLoader
{
    /**
     * @return void
     */
    protected function loadCommands(): void
    {
        $this->commands($this->commands);
    }
}
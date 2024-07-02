<?php

namespace Lazerg\LaravelModular;

/**
 * @class Modular
 * @package Lazerg\LaravelModular
 */
class Modular
{
    /**
     * @var array
     */
    protected array $modules;

    /**
     * @param string $module
     * @return void
     */
    public function addModule(string $module): void
    {
        $this->modules[] = $module;
    }
}
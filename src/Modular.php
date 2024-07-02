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
     * @param \Illuminate\Support\Collection $modules
     */
    public function __construct(public Collection $modules)
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
}
<?php

namespace Lazerg\LaravelModular\Facades;

use Illuminate\Support\Facades\Facade;
use Lazerg\LaravelModular\Modular as ModularClass;

/**
 * @class ModularFacade
 * @package Lazerg\LaravelModular\Facades
 */
class Modular extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return ModularClass::class;
    }
}
<?php

namespace Lazerg\LaravelModular\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @class ModulePath
 * @package Lazerg\LaravelModular\Facades
 */
class ModulePath extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Lazerg\LaravelModular\Services\ModulePath::class;
    }
}
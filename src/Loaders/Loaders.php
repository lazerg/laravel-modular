<?php

namespace Lazerg\LaravelModular\Loaders;

/**
 * @class Loaders
 * @package Lazerg\LaravelModular\Loaders
 */
trait Loaders
{
    use CommandsLoader,
        EventsLoader,
        ObserversLoader,
        PoliciesLoader,
        ConfigsLoader,
        MigrationsLoader,
        RoutesLoader,
        TranslationsLoader,
        ViewsLoader;
}
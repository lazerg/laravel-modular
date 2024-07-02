<?php

namespace Lazerg\LaravelModular\Loaders;

/**
 * @class TranslationsLoader
 * @package Lazerg\LaravelModular\Loaders
 */
trait TranslationsLoader
{
    /**
     * @return void
     */
    protected function loadTranslations(): void
    {
        $this->loadTranslationsFrom(
            path: $this->path . '/lang',
            namespace: $this->name
        );
    }
}
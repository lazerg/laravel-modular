<?php

namespace Lazerg\LaravelModular\Loaders;

use Illuminate\Support\Facades\File;

/**
 * @class ViewsLoader
 * @package Lazerg\LaravelModular\Loaders
 */
trait ViewsLoader
{
    /**
     * @return void
     */
    protected function loadViews(): void
    {
        if (File::exists($this->path . '/views')) {
            $this->loadViewsFrom(
                path: $this->path . '/views',
                namespace: $this->name
            );
        }
    }
}

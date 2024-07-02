<?php

namespace Lazerg\LaravelModular\Loaders;

/**
 * @class ObserversLoader
 * @package Lazerg\LaravelModular\Loaders
 */
trait ObserversLoader
{
    /**
     * @return void
     */
    protected function loadObservers(): void
    {
        foreach ($this->observers as $model => $observer) {
            /** @var \Illuminate\Database\Eloquent\Model $model */
            $model::observe($observer);
        }
    }
}
<?php

namespace Lazerg\LaravelModular\Loaders;

use Illuminate\Support\Facades\Event;

/**
 * @class EventsLoader
 * @package Lazerg\LaravelModular\Loaders
 */
trait EventsLoader
{
    /**
     * @var array
     */
    protected array $events = [];

    /**
     * @return void
     */
    protected function loadEvents(): void
    {
        foreach ($this->events as $event => $listeners) {
            foreach ((array)$listeners as $listener) {
                Event::listen($event, $listener);
            }
        }
    }
}
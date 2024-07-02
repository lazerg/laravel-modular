<?php

namespace Lazerg\LaravelModular\Loaders;

use Illuminate\Support\Facades\Gate;

/**
 * @class PoliciesLoader
 * @package Lazerg\LaravelModular\Loaders
 */
trait PoliciesLoader
{
    /**
     * @var array
     */
    protected array $policies = [];

    /**
     * @return void
     */
    protected function loadPolicies(): void
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
<?php

namespace Lazerg\LaravelModular\Services;

use Illuminate\Database\Seeder;

/**
 * @class BaseDatabaseSeeder
 * @package Lazerg\LaravelModular\Services
 */
abstract class BaseDatabaseSeeder extends Seeder
{
    /**
     * @var array
     */
    protected array $earlySeeders = [];

    /**
     * @var array
     */
    protected array $seeders = [];

    /**
     * @return array
     */
    public function getEarlySeeders(): array
    {
        return $this->earlySeeders;
    }

    /**
     * @return array
     */
    public function getSeeders(): array
    {
        return $this->seeders;
    }
}

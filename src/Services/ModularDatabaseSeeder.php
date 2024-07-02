<?php

namespace Lazerg\LaravelModular\Services;

use Lazerg\LaravelModular\Facades\ModulePath;
use Illuminate\Database\Seeder;

/**
 * @class ModularDatabaseSeeder
 * @package Lazerg\LaravelModular\Services
 */
class ModularDatabaseSeeder extends Seeder
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
     * @return void
     */
    public function run(): void
    {
        $this->addModuleSeeders();

        // write to terminal running seeders
        $this->command->info('Running ' . count($this->earlySeeders) . ' early seeders...');
        $this->call($this->earlySeeders);

        $this->command->info('Running ' . count($this->seeders) . ' seeders...');
        $this->call($this->seeders);
    }

    /**
     * @return void
     */
    protected function addModuleSeeders(): void
    {
        ModulePath::getModuleClasses('Database\Seeders\DatabaseSeeder')
            ->map(fn(string $seeder) => new $seeder())
            ->each(function (BaseDatabaseSeeder $seeder) {
                $this->earlySeeders = array_merge(
                    $this->earlySeeders,
                    $seeder->getEarlySeeders()
                );

                $this->seeders = array_merge(
                    $this->seeders,
                    $seeder->getSeeders()
                );
            });
    }
}
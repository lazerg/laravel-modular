<?php

namespace Lazerg\LaravelModular\Commands\Maker;

use Illuminate\Database\Console\Migrations\MigrateMakeCommand;
use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\Composer;
use Lazerg\LaravelModular\Facades\Modular;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

/**
 * @class MakeMigration
 * @package App\Modules\Commands\Maker
 */
class MakeMigration extends MigrateMakeCommand
{
    /**
     * @var string
     */
    protected $signature = 'module:make:migration {module} {name : The name of the migration.}
        {--create= : The table to be created.}
        {--table= : The table to migrate.}
        {--path= : The location where the migration file should be created.}
        {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths.}
        {--fullpath : Output the full path of the migration.}';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            new MigrationCreator(app('files'), '/'),
            app(Composer::class)
        );
    }

    /**
     * Get migration path (either specified by '--path' option or default location).
     *
     * @return string
     */
    protected function getMigrationPath(): string
    {
        return Modular::modulesPath(($this->argument('module')) . '/database/migrations');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return void
     */
    protected function promptForMissingArguments(InputInterface $input, OutputInterface $output): void
    {
        collect($this->getDefinition()->getArguments())
            ->reject(fn(InputArgument $argument) => $argument->getName() === 'command')
            ->filter(fn(InputArgument $argument) => $this->isMissingArgument($input, $argument))
            ->each(fn(InputArgument $argument) => $input
                ->setArgument($argument->getName(), $this->promptOptionsForMissingArguments($argument)));
    }

    /**
     * @return array
     */
    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'name' => 'What is the name of the migration? (e.g., create_users_table)',
        ];
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Input\InputArgument $argument
     * @return bool
     */
    private function isMissingArgument(InputInterface $input, InputArgument $argument): bool
    {
        return $argument->isRequired() && is_null($input->getArgument($argument->getName()));
    }

    /**
     * @param \Symfony\Component\Console\Input\InputArgument $argument
     * @return int|string|null
     */
    private function promptOptionsForMissingArguments(InputArgument $argument): int|string|null
    {
        $label = $this->promptForMissingArgumentsUsing()[$argument->getName()] ??
            'What is the ' . $argument->getName() . '?';

        return match ($argument->getName()) {
            'module' => select(
                label: $label,
                options: Modular::getModules()->toArray(),
            ),
            'name' => text(
                label: $label,
                validate: fn($value) => empty($value) ? "The {$argument->getName()} is required." : null,
            ),
            default => null,
        };
    }
}

<?php

namespace Lazerg\LaravelModular\Commands\Frontend;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Lazerg\LaravelModular\Facades\Modular;
use Spatie\Regex\Regex;

/**
 * @class TranslationsGeneratorCommand
 * @package Lazerg\LaravelModular\Commands\Frontend
 */
class TranslationsGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:frontend:translations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate translations for frontend';

    /**
     * @var array
     */
    protected array $translations = [];

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Spatie\Regex\Exceptions\RegexFailed
     */
    public function handle(): void
    {
        $this->translations = [
            'locale' => config('app.locale'),
        ];

        Modular::getModuleFiles('/lang')
            ->each(function (array $paths, string $module) {
                foreach ($paths as $path) {
                    $this->addTranslation($module, $path);
                }
            });

        $path = base_path('frontend/resources/translations.json');
        $json = json_encode($this->translations, JSON_PRETTY_PRINT);

        File::put($path, $json);

        $this->info('Translations generated successfully.');
    }

    /**
     * @param string $module
     * @param string $path
     * @return void
     * @throws \Spatie\Regex\Exceptions\RegexFailed
     */
    protected function addTranslation(string $module, string $path): void
    {
        // lang/{match-1}/{match-2}.php
        $matches = Regex::match('/\/lang\/([^\/]+)\/([^\/]+)\.php/', $path);

        $key = implode('.', [
            $matches->group(1),
            strtolower($module),
            $matches->group(2),
        ]);

        Arr::set($this->translations, $key, include $path);
    }
}
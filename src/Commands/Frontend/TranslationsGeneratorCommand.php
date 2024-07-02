<?php

namespace Lazerg\LaravelModular\Commands\Frontend;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

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
     */
    public function handle(): void
    {
        $this->translations = [
            'locale' => config('app.locale'),
        ];

        collect(trans()->getLoader()->namespaces())
            ->filter(fn(string $path) => File::isDirectory($path))
            ->each(function (string $path, string $module) {
                foreach (File::allFiles($path) as $file) {
                    $this->addTranslation(
                        module: $module,
                        locale: $file->getRelativePath(),
                        file: $file->getFilenameWithoutExtension(),
                        path: $file->getPathname()
                    );
                }
            });

        $path = base_path('frontend/resources/translations.json');
        $json = json_encode($this->translations, JSON_PRETTY_PRINT);

        File::put($path, $json);

        $this->info('Translations generated successfully.');
    }

    /**
     * @param string $module
     * @param string $locale
     * @param string $file
     * @param string $path
     * @return void
     */
    protected function addTranslation(
        string $module,
        string $locale,
        string $file,
        string $path
    ): void {
        $key = implode('.', [
            $locale,
            $module,
            $file,
        ]);

        Arr::set($this->translations, $key, include $path);
    }
}
<?php

namespace Lazerg\LaravelModular\Loaders;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;

/**
 * @class ConfigsLoader
 * @package Lazerg\LaravelModular\Loaders
 */
trait ConfigsLoader
{
    /**
     * @return void
     */
    protected function loadConfigs(): void
    {
        if (!File::exists($this->path . '/config')) {
            return;
        }

        foreach (File::files($this->path . '/config') as $file) {
            $this->loadConfigFile($file);
        }
    }

    /**
     * @param SplFileInfo $file
     * @return void
     */
    protected function loadConfigFile(SplFileInfo $file): void
    {
        $fileName = Str::remove('.php', $file->getFilename());
        $key      = $this->name . '::' . $fileName;

        $this->mergeConfigFrom($file->getPathname(), $key);
    }
}
<?php

namespace Lazerg\LaravelModular\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SplFileInfo;

/**
 * @class ModulePath
 * @package Lazerg\LaravelModular\Services
 */
class ModulePath
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function modules(): Collection
    {
        return collect(File::directories(modules_path()))
            ->map(fn(string $directory) => Str::afterLast($directory, '/'));
    }

    /**
     * @param string $pattern
     * @return mixed
     */
    public function getModuleClasses(string $pattern): Collection
    {
        return $this
            ->modules()
            ->map(fn(string $module) => "Modules\\$module\\$pattern")
            ->filter(fn(string $class) => class_exists($class))
            ->values();
    }

    /**
     * @param string $path
     * @return Collection
     */
    public function getModuleFiles(string $path): Collection
    {
        return $this
            ->modules()
            ->mapWithKeys(fn(string $module) => [$module => modules_path($module . $path)])
            ->filter(fn(string $path) => File::isDirectory($path))
            ->map(function (string $path) {
                return array_map(
                    fn(SplFileInfo $file) => $file->getRealPath(),
                    File::allFiles($path)
                );
            });
    }
}
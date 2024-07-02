<?php

namespace Lazerg\LaravelModular\Loaders;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * @class RoutesLoader
 * @package App\Modules\Loaders
 */
trait RoutesLoader
{
    /**
     * @return void
     */
    public function loadRoutes(): void
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        $prefix = $this->disableRoutePluralization
            ? Str::kebab($this->name)
            : Str::kebab(Str::plural($this->name));

        $this->loadRoutesFromFile('web.php', [
            'middleware' => $this->getMiddlewares(['web']),
            'namespace'  => 'Modules\\' . $this->name . '\\Http\\Controllers',
            'prefix'     => $this->disableWebRoutePrefix ? '' : $prefix,
            'as'         => $prefix . '.',
        ]);

        $this->loadRoutesFromFile('api.php', [
            'middleware' => $this->getMiddlewares(['api']),
            'namespace'  => 'Modules\\' . $this->name . '\\Http\\Controllers\\Api',
            'prefix'     => 'api/' . $prefix,
            'as'         => 'api.' . $prefix . '.',
        ]);

        $this->loadRoutesFromFile('console.php', []);
    }

    /**
     * @param string $file
     * @param array $attributes
     * @return void
     */
    protected function loadRoutesFromFile(string $file, array $attributes): void
    {
        $routes = $this->path . '/routes/' . $file;

        if (File::exists($routes)) {
            Route::group($attributes, $routes);
        }
    }

    /**
     * @param array $middleware
     * @return array
     */
    protected function getMiddlewares(array $middleware = []): array
    {
        if ($this->mustBeAuthenticated) {
            $middleware[] = 'auth';
        }

        if ($this->mustBeGuest) {
            $middleware[] = 'guest';
        }

        return $middleware;
    }
}
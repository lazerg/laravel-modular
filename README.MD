![cover](./assets/cover.png)

![Version](https://img.shields.io/packagist/v/lazerg/laravel-modular.svg?style=plastic)
![Downloads count](https://img.shields.io/packagist/dm/lazerg/laravel-modular?style=plastic)
![Repository count](https://img.shields.io/github/repo-size/lazerg/laravel-modular?style=plastic)
![Last commit](https://img.shields.io/github/last-commit/lazerg/laravel-modular?style=plastic)
![Stars count](https://img.shields.io/packagist/stars/lazerg/laravel-modular?style=plastic)

Dividing a Laravel project into modules enhances code organisation by isolating features and functionalities into
separate,
manageable units. This modular approach improves scalability by allowing each module to be developed, tested,
and maintained independently, which speeds up development and reduces the risk of conflicts.

It also promotes reusability, as modules can be easily reused in other projects, fostering
a more efficient development process and reducing duplication of effort.

## Installation

```bash
composer require lazerg/laravel-modular
```

## Create a new module `User`

First start from registering new module in `composer.json` file.

```json
{
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/",
            "Modules\\User\\": "modules/User/app/",
            "Modules\\User\\Database\\Factories\\": "modules/User/database/factories/",
            "Modules\\User\\Database\\Seeders\\": "modules/User/database/seeders/"
        }
    }
}
```

After changing the `composer.json` file, run the following command to update the autoloader.

```bash
composer dump-autoload
```

Then create a new service provider for the module. It must be located in the `app/Modules/User/app` directory.

```php
<?php

namespace Modules\User;

use Lazerg\LaravelModular\ModuleServiceProvider;

class UserServiceProvider extends ModuleServiceProvider
{
    //
}
```

Register the new service provider in the `bootstrap/providers.php` file.

```php
<?php

return [
    App\Providers\AppServiceProvider::class,

    # Modules
    Modules\User\UserServiceProvider::class,
];
```

### We can move default files to module now

1. Move `/app/Modules/User` to `/modules/User/app/Modes/User`
2. Change `auth.providers.users.model` config to `Modules\User\Models\User`.
3. Move `/database/migrations/2014_10_12_000000_create_users_table.php`
   to `/modules/User/database/migrations/2014_10_12_000000_create_users_table.php`
4. Move `/database/factories/UserFactory.php` to `/modules/User/database/factories/UserFactory.php`

### Setup seeder

1. `database/seeders/DatabaseSeeder.php` must extend `ModularDatabaseSeeder`. And do not override `run` method.
2. Create `DatabaseSeeder` in `modules/User/database/seeders` directory. It must extend `BaseDatabaseSeeder`
3. Create `UserSeeder` in `modules/User/database/seeders` directory. It must extends `Illuminate\Database\Seeder`
4. Register `UserSeeder` in `DatabaseSeeder`'s `$earlySeeders` or `$seeders` property.

### Loaders

Inside `ModuleServiceProvider` we have different loaders:

| Loader                            | Register                                                                                                                   | Path                                   |
|-----------------------------------|----------------------------------------------------------------------------------------------------------------------------|----------------------------------------|
| `Loaders/CommandsLoader`          | `$commands` property in ServiceProvider                                                                                    | `modules/{module}/app/Commands`        |
| `Loaders/EventsLoader`            | `$events` property in ServiceProvider.                                                                                     | `modules/{module}/app/Events`          |
| `Loaders/ObserversLoader`         | `$observers` property in ServiceProvider                                                                                   | `modules/{module}/app/Observers`       |
| `Loaders/PoliciesLoader`          | `$policies` property in ServiceProvider                                                                                    | `modules/{module}/app/Policies`        |
| `Loaders/ConfigsLoader`           | all files from `modules/{module}/config` folder.                                                                           | `modules/{module}/config`              |
| `Loaders/MigrationsLoader`        | all files from `modules/{module}/database/migrations` folder                                                               | `modules/{module}/database/migrations` |
| `Loaders/RoutesLoader`            | `web.php`, `api.php` and `console.php` from `modules/{module}/routes` folder                                               | `modules/{module}/routes`              |
| `Loaders/TranslationsLoader`      | all langs from `modules/{module}/lang` folder                                                                              | `modules/{module}/lang`                |
| `Loaders/ViewsLoader`             | all views from `modules/{module}/views` folder                                                                             | `modules/{module}/views`               |
| `database/seeders/DatabaseSeeder` | `DatabaseSeeder` class from `modules/{module}/database/seeders` folder will be loaded. It must extend `BaseDatabaseSeeder` | `modules/{module}/database/seeders`    |

### Routes

Lets say we have a route in `web.php`:

```php
Route::get('/index', [UserController::class, 'index'])->name('index');
```

Final name of this route will be `users.index`. Because module called `User`.
If you want to disable pluralization, you can set `disableRoutePluralization`
property to `true` in `{Module}ServiceProvider`. This route will be accessible in `/users/index` URL.
If pluralization is disabled, it will be accessible in `/user/index` URL. If route prefix is disabled
it will be accessible in `/index` URL. You can disable route prefix by setting `disableWebRoutePrefix` property
to `true`. Namespace of the controller will be `Modules\User\Http\Controllers`.

-------------------

Lets say we have a route in `api.php`:

```php
Route::get('/index', [UserController::class, 'index'])->name('index');
```

Final name of this route will be `api.users.index`. Because module called `User`.
If you want to disable pluralization, you can set `disableRoutePluralization`
property to `true` in `{Module}ServiceProvider`. This way name will become `api.user.index` and url become 
`/api/user/index`. Namespace of the controller will be `Modules\User\Http\Api\Controllers`.

For more understanding, you can check `RoutesLoader.php` file.

### Config

To access config, you can use `config('User::auth.type')`. It will get `type` from `modules/User/config/auth.php` file.

```php
config('user.user_model');
```

### Translation

To access translation, you can use `__('User::auth.type')`. It will get `type` from `modules/User/lang/en/auth.php` file.

### Views

To access view, you can use `view('User::auth.login')`. 
It will get `login` view from `modules/User/views/auth/login.blade.php` file.
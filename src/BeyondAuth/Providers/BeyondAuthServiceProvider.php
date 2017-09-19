<?php

namespace Pribumi\BeyondAuth\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Pribumi\BeyondAuth\AuthManager;
use Pribumi\BeyondAuth\BeyondAuth;
use Pribumi\BeyondAuth\Models\ApiKeyUsers;
use Pribumi\BeyondAuth\Models\FieldTypes;
use Pribumi\BeyondAuth\Models\Periode;
use Pribumi\BeyondAuth\Models\User;
use Pribumi\BeyondAuth\Models\UserActivation;
use Pribumi\BeyondAuth\Models\UserField;
use Pribumi\BeyondAuth\Models\UserFieldGroup;
use Pribumi\BeyondAuth\Models\UserFieldValue;
use Pribumi\BeyondAuth\Models\UserGroup;
use Pribumi\BeyondAuth\Models\UserMenus;
use Pribumi\BeyondAuth\Models\UserPermission;
use Pribumi\BeyondAuth\Repositories\EloquentApiKeyUsersRepository;
use Pribumi\BeyondAuth\Repositories\EloquentFieldTypesRepository;
use Pribumi\BeyondAuth\Repositories\EloquentPeriodeRepository;
use Pribumi\BeyondAuth\Repositories\EloquentUserActivationRepository;
use Pribumi\BeyondAuth\Repositories\EloquentUserFieldGroupRepository;
use Pribumi\BeyondAuth\Repositories\EloquentUserFieldRepository;
use Pribumi\BeyondAuth\Repositories\EloquentUserFieldValueRepository;
use Pribumi\BeyondAuth\Repositories\EloquentUserGroupRepository;
use Pribumi\BeyondAuth\Repositories\EloquentUserMenuRepository;
use Pribumi\BeyondAuth\Repositories\EloquentUserPermissionRepository;
use Pribumi\BeyondAuth\Repositories\EloquentUserRepository;
use ReflectionClass;

/**
 * Class BeyondAuthServiceProvider
 *
 * @package Pribumi\BeyondAuth\Providers
 * @version    1.0.0
 * @author     Pribumi Technology
 * @license    MIT
 * @copyright  (c) 2015 - 2016, Pribumi Technology
 * @link       http://pribumitech.com
 */
class BeyondAuthServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $extend = static::canUseDependentValidation() ? 'extendDependent' : 'extend';
        //$this->app['validator']->{$extend}('beyondauth', 'Pribumi\BeyondAuth\Validators\Validator@validatePhone');

        //$this->publishLanguages();
        $this->publishConfig();
        $this->publishMigrations();
        $this->publishSeeder();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCustomUser();
        $this->loadHelpers();
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            'beyondauth',
            'Pribumi\BeyondAuth\Contracts\Factory',
            'beyondauth.manager',
            'beyondauth.facade',
            'beyondauth.user',
            'beyondauth.role',
            'beyondauth.usersfields_groups',
            'beyondauth.usersfields',
            'beyondauth.users_menus',
            'beyondauth.user_permissions',
            'beyondauth.usersfields_value',
            'beyondauth.usersactivations',
            'beyondauth.apikeyuser',
        ];
    }

    /**
     * Publishing Configuration file to main laravel app
     *
     * package config files
     * php artisan vendor:publish --provider="Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider" --tag="seeds"
     * @return void
     */
    private function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../../config/beyondauth.php' => config_path('beyondauth.php'),
        ], 'config');
    }

    /**
     * Publishing Configuration file to main laravel app
     *
     * package config files
     * php artisan vendor:publish --provider="Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider" --tag="seeds"
     * @return void
     */
    private function publishLanguages()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'beyondauth');

        $this->publishes([
            __DIR__ . '/../../resources/lang/' => base_path('resources/lang/vendor/beyondauth'),
        ]);
    }

    /**
     * Publishing Database seeder
     *
     * package config files
     * php artisan vendor:publish --provider="Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider" --tag="config"
     * @return void
     */
    private function publishSeeder()
    {
        $this->publishes([
            __DIR__ . '/../../database/seeds/' => base_path('database/seeds'),
        ], 'seeds');
    }

    /**
     * Publishing migration file to main laravel app
     *
     * <code>
     * php artisan vendor:publish --provider="Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider" --tag="migrations"
     * php artisan migrate
     * </code>
     *
     * @return void
     */
    private function publishMigrations()
    {
        $this->publishes([
            __DIR__ . '/../../database/migrations' => base_path('database/migrations'),
        ], 'migrations');
    }

    /**
     * Register Custom UserProvider.
     *
     * @return void
     */
    protected function registerCustomUser()
    {

        $this->app->singleton('beyondauth.manager', function ($app) {
            return new AuthManager($app);
        });

        /**
         * Beritahu ke laravel bahwa beyondauth.auth di extend ke auth (milik laravel)
         */
        $this->app->singleton('beyondauth.auth', function ($app) {
            return $app['auth'];
        });

        /**
         * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerFacades
         */
        $this->app->singleton('beyondauth.usergroup', function ($app) {
            return new EloquentUserGroupRepository($app, new UserGroup());
        });

        /**
         * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerFacades
         */
        $this->app->singleton('beyondauth.periode', function ($app) {
            return new EloquentPeriodeRepository($app, new Periode());
        });

        /**
         * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerFacades
         */
        $this->app->singleton('beyondauth.usersfields', function ($app) {
            return new EloquentUserFieldRepository($app, new UserField());
        });

        /**
         * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerFacades
         */
        $this->app->singleton('beyondauth.usersfields_groups', function ($app) {
            return new EloquentUserFieldGroupRepository($app, new UserFieldGroup());
        });

        /**
         * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerFacades
         */
        $this->app->singleton('beyondauth.users_menus', function ($app) {
            return new EloquentUserMenuRepository($app, new UserMenus());
        });

        /**
         * @see \Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::registerFacades
         */
        $this->app->singleton('beyondauth.user_permissions', function ($app) {
            return new EloquentUserPermissionRepository($app, new UserPermission());
        });

        $this->app->singleton('beyondauth.fieldtypes', function ($app) {
            return new EloquentFieldTypesRepository($app, new FieldTypes());
        });

        $this->app->singleton('beyondauth.usersfields_value', function ($app) {
            return new EloquentUserFieldValueRepository($app, new UserFieldValue());
        });

        $this->app->singleton('beyondauth.usersactivations', function ($app) {
            return new EloquentUserActivationRepository($app, new UserActivation());
        });

        $this->app->singleton('beyondauth.apikeyuser', function ($app) {
            return new EloquentApiKeyUsersRepository($app, new ApiKeyUsers());
        });

        $this->app->singleton('beyondauth.user', function ($app) {
            return new EloquentUserRepository($app, new User(), new UserField(), new UserActivation(), new UserFieldValue());
        });

        $this->registerFacades();
    }

    /**
     * Load the helpers file.
     */
    private function loadHelpers()
    {
        if ($this->app['config']->get('beyondauth.helpers', true)) {
            require_once __DIR__ . '/../helpers.php';
        }
    }

    /**
     * Determine whether we can register a dependent validator.
     *
     * @return bool
     */
    public static function canUseDependentValidation()
    {
        $validator = new ReflectionClass('\Illuminate\Validation\Factory');

        return $validator->hasMethod('extendDependent');
    }

    /**
     * Register Core BeyondAuth
     * Ini agar mempermudah programmer untuk menggunakannya
     * dikarenakan Method Seluruhnya berupa `Singleton`.
     *
     * @see \Pribumi\BeyondAuth\BeyondAuth::__construct
     *
     * @return \Pribumi\BeyondAuth\BeyondAuth
     */
    protected function registerFacades()
    {
        $this->app->singleton('beyondauth.facade', function ($app) {
            return new BeyondAuth($app,
                $app['beyondauth.user'],
                $app['beyondauth.usergroup'],
                $app['beyondauth.periode'],
                $app['beyondauth.usersfields_groups'],
                $app['beyondauth.usersfields'],
                $app['beyondauth.users_menus'],
                $app['beyondauth.user_permissions'],
                $app['beyondauth.fieldtypes'],
                $app['beyondauth.usersfields_value'],
                $app['beyondauth.usersactivations'],
                $app['beyondauth.apikeyuser']);
        });
    }
}

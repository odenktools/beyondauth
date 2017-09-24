# Beyond Auth

[![License](https://poser.pugx.org/pribumi/beyondauth/license)](https://packagist.org/packages/pribumi/beyondauth)

What is BeyondAuth? .... tobe continued

# Installing Package

```bash
composer require pribumi/beyondauth
```

# Setup

After updating, add the service provider to the `providers` array in `config/app.php`

	Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::class,

Also add the aliases to the `aliases` array in `config/app.php`

	'BeyondAuth'  => Pribumi\BeyondAuth\Facades\BeyondAuth::class,

Run command from your console ``composer dump-autoload``

Replace code on `guards` array in `config/auth.php` like this

        'web_admins' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

And also on `providers` array too

        'users' => [
            'driver' => 'eloquent',
            'model' => Pribumi\BeyondAuth\Models\User::class,
        ],

Change default guard

    'defaults' => [
        'guard' => 'web_admins',
        'passwords' => 'users',
    ],
	
Publish BeyondAuth

	php artisan vendor:publish --provider="Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider"

# Migrate

Before you test the code, make sure your application can connect to the database then run this `command`

	php artisan migrate
	
	composer dumpautoload
	
	php artisan db:seed --class=BeyondAuthSeeder

# Publish Config

Publish BeyondAuth `config` file using this command

	php artisan vendor:publish --provider="Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider" --tag="config"

# Register on Kernel

	protected $routeMiddleware = [
		... bla... blaa...
		'beyondauth' => \Pribumi\BeyondAuth\Http\Middleware\BeyondMiddleware::class
	]

# Testing

Work on progress...
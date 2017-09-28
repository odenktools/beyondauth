# Beyond Auth

[![Build Status](https://travis-ci.org/odenktools/beyondauth.svg)](https://travis-ci.org/odenktools/beyondauth)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e5044efb-e10a-4cc4-84f7-e243ca0ebc62/small.png)](https://insight.sensiolabs.com/projects/e5044efb-e10a-4cc4-84f7-e243ca0ebc62)

[![License](https://poser.pugx.org/pribumi/beyondauth/license)](https://packagist.org/packages/pribumi/beyondauth)

What is BeyondAuth? .... tobe continued

# Installing Package

```bash
composer require pribumi/beyondauth
```

# Setup

After updating, add the service provider to the `providers` array in `config/app.php`

```php
'providers' => [
	//bla.. bla..
	Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider::class,
]
```

Also add the aliases to the `aliases` array in `config/app.php`

```php
'aliases' => [
	'BeyondAuth'  => Pribumi\BeyondAuth\Facades\BeyondAuth::class,
]
```

Run command from your console ``composer dump-autoload``

Replace code on `guards` array in `config/auth.php` like this

```php
'web_admins' => [
	'driver' => 'session',
    'provider' => 'users'
],
```
And also on `providers` array too

```php
'users' => [
    'driver' => 'eloquent',
    'model' => Pribumi\BeyondAuth\Models\User::class,
],
```

Change default guard

```php
	'defaults' => [
    	'guard' => 'web_admins',
        'passwords' => 'users',
    ]
```

#### Publish BeyondAuth

```bash
	php artisan vendor:publish --provider="Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider"
```

# Migrate

Before you test the code, make sure your application can connect to the database then run this `command`

```bash
php artisan migrate

composer dumpautoload

php artisan db:seed --class=BeyondAuthSeeder
```

# Publish Config

Publish BeyondAuth `config` file using this command

```bash
php artisan vendor:publish --provider="Pribumi\BeyondAuth\Providers\BeyondAuthServiceProvider" --tag="config"
```

# Register on Kernel

```php
protected $routeMiddleware = [
	//... bla... blaa...
	'beyondauth' => \Pribumi\BeyondAuth\Http\Middleware\BeyondMiddleware::class
]
```

# Model Relationships

```php
```

#### PERIODE

```php
$periode = new \Pribumi\BeyondAuth\Models\Periode();
$findIdPeriode = $periode->find(3);
echo json_encode($findIdPeriode->usergroups);
```

#### USER

```php
$userfields = \BeyondAuth::users()->find(1)->userfields()->get();
echo json_encode($userfields);
```

```php
$uservalues = \BeyondAuth::users()->find(1)->roles()->get();
echo json_encode($uservalues);
```

```php
$uservalues = \BeyondAuth::users()->find(1)->uservalues()->get();
echo json_encode($uservalues);
```

# Testing

Work on progress...

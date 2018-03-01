Laravel 5 Job Status Viewer
======================

[![Packagist](https://img.shields.io/packagist/v/atlas-wong/laravel-log-viewer.svg)]()

TL;DR
-----
Job Status Viewer for Laravel 5 (compatible with 4.2 too) and Lumen. **Install with composer, create a route to `JobStatusViewerController`**. No public assets, no vendor routes, works with and/or without log rotate. 
Depend on ImTigger's laravel-job-status package (https://github.com/imTigger/laravel-job-status)

What ?
------
Job status viewer for laravel. Looks like this:

![capture d ecran 2014-12-01 a 10 37 18](https://cloud.githubusercontent.com/assets/1575946/5243642/8a00b83a-7946-11e4-8bad-5c705f328bcc.png)

Install (Laravel)
-----------------
Install via composer
```
composer require atlas-wong/laravel-log-viewer
```

Add Service Provider to `config/app.php` in `providers` section
```php
AtlasWong\LaravelLogViewer\LaravelLogViewerServiceProvider::class,
```

Add a route in your web routes file:
```php 
Route::get('logs', '\AtlasWong\LaravelLogViewer\LogViewerController@index');
```

Go to `http://myapp/logs` or some other route

**Optionally** publish `laravel-log-viewer.php` into `/config` for config customization:

```
php artisan vendor:publish --provider="AtlasWong\LaravelLogViewer\LaravelLogViewerServiceProvider" --tag=config
``` 

**Optionally** publish `log.blade.php` into `/resources/views/vendor/laravel-log-viewer/` for view customization:

```
php artisan vendor:publish --provider="AtlasWong\LaravelLogViewer\LaravelLogViewerServiceProvider" --tag=views
``` 

Install (Lumen)
---------------

Install via composer
```
composer require AtlasWong/laravel-log-viewer
```

Add the following in `bootstrap/app.php`:
```php
$app->register(\AtlasWong\LaravelLogViewer\LaravelLogViewerServiceProvider::class);
```

Explicitly set the namespace in `app/Http/routes.php`:
```php
$app->group(['namespace' => '\AtlasWong\LaravelLogViewer'], function() use ($app) {
    $app->get('logs', 'LogViewerController@index');
});
```

Troubleshooting
---------------

If you got a `InvalidArgumentException in FileViewFinder.php` error, it may be a problem with config caching. Double check installation, then run `php artisan config:clear`.


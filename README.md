Laravel 5 Job Status Viewer
======================

![Packagist](https://img.shields.io/packagist/v/atlas-wong/laravel-job-status-viewer.svg)

TL;DR
-----
Job Status Viewer for Laravel 5 (compatible with 4.2 too) and Lumen. **Install with composer, create a route to `JobStatusViewerController`**. No public assets, no vendor routes, works with and/or without log rotate. 

Depend on ImTigger's laravel-job-status package (https://github.com/imTigger/laravel-job-status)

What ?
------
Job status viewer for laravel.

Install (Laravel)
-----------------
Install via composer
```
composer require atlas-wong/laravel-job-status-viewer
```

Add Service Provider to `config/app.php` in `providers` section
```php
AtlasWong\LaravelJobStatusViewer\LaravelJobStatusViewerServiceProvider::class,
```

Add a route in your web routes file:
```php 
Route::get('job-status-viewer', '\AtlasWong\LaravelJobStatusViewer\JobStatusViewerController@index');
```

Go to `http://myapp/job-status-viewer` or some other route

**Optionally** publish `laravel-job-status-viewer.php` into `/config` for config customization:

```
php artisan vendor:publish --provider="AtlasWong\LaravelJobStatusViewer\LaravelJobStatusViewerServiceProvider" --tag=config
``` 

**Optionally** publish `status.blade.php` into `/resources/views/vendor/laravel-job-status-viewer/` for view customization:

```
php artisan vendor:publish --provider="AtlasWong\LaravelJobStatusViewer\LaravelJobStatusViewerServiceProvider" --tag=views
``` 

Install (Lumen)
---------------

Install via composer
```
composer require AtlasWong/laravel-job-status-viewer
```

Add the following in `bootstrap/app.php`:
```php
$app->register(\AtlasWong\LaravelJobStatusViewer\LaravelJobStatusViewerServiceProvider::class);
```

Explicitly set the namespace in `app/Http/routes.php`:
```php
$app->group(['namespace' => '\AtlasWong\LaravelJobStatusViewer'], function() use ($app) {
    $app->get('job-status-viewer', 'JobStatusViewerController@index');
});
```

Troubleshooting
---------------


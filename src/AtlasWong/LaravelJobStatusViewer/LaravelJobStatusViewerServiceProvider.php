<?php
namespace AtlasWong\LaravelJobStatusViewer;

use Illuminate\Support\ServiceProvider;

class LaravelJobStatusServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		if (method_exists($this, 'package')) {
			$this->package('atlas-wong/laravel-job-status-viewer', 'laravel-job-status-viewer', __DIR__ . '/../../');
		}

		if (method_exists($this, 'loadViewsFrom')) {
			$this->loadViewsFrom(__DIR__.'/../../views', 'laravel-job-status-viewer');
		}
        
        if (method_exists($this, 'publishes')) {
            $this->publishes([
                __DIR__ . '/../../config/laravel-job-status-viewer.php' => config_path('laravel-job-status-viewer.php')
            ], 'config');
    
            $this->publishes([
                __DIR__ . '/../../views' => resource_path('views/vendor/laravel-job-status-viewer')
            ], 'views');
        }
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/laravel-job-status-viewer.php', 'laravel-job-status-viewer'
        );
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}

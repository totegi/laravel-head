<?php namespace Gwnobots\LaravelHead;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class LaravelHeadServiceProvider extends ServiceProvider {

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
		if(preg_match('/^4/',Application::VERSION))
		{
			$this->package('gwnobots/laravel-head');
		}
		else 
		{
			$configPath = __DIR__.'/../../config/config.php';
			$this->publishes([
				$configPath => config_path('laravel-head.php'),
			]);
			
			$this->mergeConfigFrom($configPath, 'laravel-head');
		}
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['laravel-head'] = $this->app->share(function($app)
		{
			return new LaravelHead;
		});

		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Head', 'Gwnobots\LaravelHead\LaravelHeadFacade');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('laravel-head');
	}

}

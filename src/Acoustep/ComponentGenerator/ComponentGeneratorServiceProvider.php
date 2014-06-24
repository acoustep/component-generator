<?php namespace Acoustep\ComponentGenerator;

use Config;
use Illuminate\Support\ServiceProvider;
use Acoustep\ComponentGenerator\Commands\ComponentGeneratorCommand;
use Acoustep\ComponentGenerator\Generators\ComponentGenerator;
use Acoustep\ComponentGenerator\Commands\ComponentAppenderCommand;
use Acoustep\ComponentGenerator\Generators\ComponentAppender;

class ComponentGeneratorServiceProvider extends ServiceProvider {

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
		$this->package('acoustep/component-generator');

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerComponentGeneratorCommand();

		$this->commands(
			'component.generate',
			'component.append'
		);
	}
	public function registerComponentGeneratorCommand()
	{
		$this->app['component.generate'] = $this->app->share(function($app)
		{
			$generator = new ComponentGenerator($app['files'], $app['config']);
			return new ComponentGeneratorCommand($generator, $app['config']);
		});
		$this->app['component.append'] = $this->app->share(function($app)
		{
			$generator = new ComponentAppender($app['files'], $app['config']);
			return new ComponentAppenderCommand($generator, $app['config']);
		});
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

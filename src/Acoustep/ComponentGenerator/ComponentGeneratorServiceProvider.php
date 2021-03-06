<?php namespace Acoustep\ComponentGenerator;

use Config;
use Illuminate\Support\ServiceProvider;
use Acoustep\ComponentGenerator\Commands\ComponentGeneratorCommand;
use Acoustep\ComponentGenerator\Generators\ComponentGenerator;
use Acoustep\ComponentGenerator\Commands\ComponentAppenderCommand;
use Acoustep\ComponentGenerator\Generators\ComponentAppender;
use Acoustep\ComponentGenerator\Commands\ComponentSetupCommand;
use Acoustep\ComponentGenerator\Generators\ComponentSetup;
use Acoustep\ComponentGenerator\Commands\ComponentListCommand;

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
			'component.append',
			'component.setup',
			'component.list'
		);
	}
	public function registerComponentGeneratorCommand()
	{
		$this->app['component.list'] = $this->app->share(function($app)
		{
			return new ComponentListCommand();
		});

		$this->app['component.generate'] = $this->app->share(function($app)
		{
			$generator = new ComponentGenerator($app['files'], $app['config'], app_path());
			return new ComponentGeneratorCommand($generator, $app['config']);
		});
		
		$this->app['component.append'] = $this->app->share(function($app)
		{
			$generator = new ComponentAppender($app['files'], $app['config']);
			return new ComponentAppenderCommand($generator, $app['config']);
		});

		$this->app['component.setup'] = $this->app->share(function($app)
		{
			$generator = new ComponentSetup($app['files'], $app['config'], app_path(), '/config/packages/acoustep/component-generator');
			return new ComponentSetupCommand($generator, $app['config']);
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

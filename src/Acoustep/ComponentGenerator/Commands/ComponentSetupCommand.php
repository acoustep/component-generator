<?php namespace Acoustep\ComponentGenerator\Commands;

use Acoustep\ComponentGenerator\Generators\ComponentSetup;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ComponentSetupCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'component:setup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Setup Component Generator';

	protected $generator;
	protected $config;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(ComponentSetup $generator, $config)
	{
		$this->config = $config;
		parent::__construct();
		$this->generator = $generator;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$syntax = $this->ask("Blade or PHP templates? (blade)", "blade", ['blade', 'php']);
		if( ! in_array($syntax, ['blade', 'php']))
			return $this->error('Your syntax must be blade or php');

		$location = $this->ask("Where do you want components to be generated? (app/views/components)", "app/views/components");
		$framework = $this->ask("Choose a Framework: bootstrap3, foundation5 or pure1? (bootstrap3)", "bootstrap3");
		if($this->generator->make($syntax, $location, $framework))
			$this->info("Setup complete");
		else
			$this->error('Could not complete setup.  Check your options and file permissions.');
	}

}




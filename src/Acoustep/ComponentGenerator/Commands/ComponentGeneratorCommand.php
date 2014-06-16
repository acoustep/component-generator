<?php namespace Acoustep\ComponentGenerator\Commands;

use Acoustep\ComponentGenerator\Generators\ComponentGenerator;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ComponentGeneratorCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate:component';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate a HTML component from a web framework such as Twitter Bootstrap or Zurb Foundation.';

	protected $generator;
	protected $config;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(ComponentGenerator $generator, $config)
	{
		parent::__construct();
		$this->generator = $generator;
		$this->config = $config;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$path = $this->getPath();

		if($this->generator->make($path))
			$this->info("Created {$path}");
		else
			$this->error("Could not create {$path}");
	}

	public function getPath()
	{
		return $this->option('path') . '/' .
			$this->config->get('component-generator::config.prefix') .
			$this->argument('name') . $this->config->get('component-generator::config.postfix');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('name', 
			InputArgument::REQUIRED, 
			'The name of the component to generate.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('path',
			null,
			InputOption::VALUE_OPTIONAL,
			'Path to the view components directory.',
		 	'app/views/components'),
		);
	}

}


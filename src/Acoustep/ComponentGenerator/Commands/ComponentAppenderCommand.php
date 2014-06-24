<?php namespace Acoustep\ComponentGenerator\Commands;

use Acoustep\ComponentGenerator\Generators\ComponentAppender;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ComponentAppenderCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'component:append';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Append a HTML component to an existing file.';

	protected $generator;
	protected $config;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(ComponentAppender $generator, $config)
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
		if($this->generator->make($this->argument('name'), 'app.views.'.$this->argument('file')))
			$this->info("Appended {$this->argument('name')} to app/views/".str_replace('.', '/', $this->argument('file'))."(.blade.php|.php).");
		else
			$this->error("Could not appended template to app/views/".str_replace('.', '/', $this->argument('file'))."(.blade.php|.php). Did you mean component:generate?");
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
			array('file', 
			InputArgument::REQUIRED, 
			'The file to append the component to.'),
		);
	}
}



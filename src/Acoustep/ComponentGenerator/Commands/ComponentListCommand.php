<?php namespace Acoustep\ComponentGenerator\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Exception;

class ComponentListCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'component:list';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'List all of the components available.';

	public function fire()
	{
		$frameworks = $this->getFrameworks();

		foreach($frameworks as $framework) {
			$templates = $this->getTemplates($framework);
			$this->outputFormattedList($framework, $templates);
		}
	}

	protected function filterFrameworks($frameworks)
	{
		if( ! $this->option('framework')) 
			return $frameworks;

		$index = array_search($this->option('framework'), $frameworks);

		if( ! $index)
			throw new Exception("Could not find framework directory.");
		return [$frameworks[$index]];
	}

	protected function outputFormattedList($framework, $templates)
	{
		$this->comment($framework);
		foreach($templates as $template) {
			$this->info("  ".rtrim($template, '.txt'));
		}
	}

	protected function getFrameworks()
	{
		$frameworks =  array_diff(scandir(__DIR__.'/../../../views/'), ['..', '.', '.gitkeep']);
		return $this->filterFrameworks($frameworks);
	}

	protected function getTemplates($framework)
	{
		return array_diff(scandir(__DIR__.'/../../../views/'.$framework.'/'), ['..', '.', '.gitignore']);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			[
				'framework',
				null,
				InputOption::VALUE_OPTIONAL,
				'The framework or directory to list templates from. All by default.',
				false,
			],
		];
	}
}

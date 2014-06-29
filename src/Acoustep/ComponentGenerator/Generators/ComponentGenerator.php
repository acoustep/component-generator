<?php namespace Acoustep\ComponentGenerator\Generators;

use Illuminate\Filesystem\Filesystem as File;

class ComponentGenerator {
	protected $file;
	protected $config;
	protected $app_path;

	public function __construct(File $file, $config, $app_path)
	{
		$this->file = $file;
		$this->config = $config;
		$this->app_path = $app_path;
	}
	public function make($path)
	{ 
		$name = basename(
			$path, 
			$this->config->get('component-generator::config.postfix'
		));

		$template = $this->getTemplate($name);

		$path_parts = pathinfo($path);

		$path = $path_parts['dirname'] .
			'/' .
			$this->config->get('component-generator::config.prefix') .
			$path_parts['basename'];

		if( ! $this->file->isDirectory($this->app_path.'/../'.$path_parts['dirname']))
			$this->file->makeDirectory($this->app_path.'/../'.$path_parts['dirname']);

		if( ! $this->file->exists($path))
			return $this->file->put($path, $template);
		return false;
 	}

	public function getTemplate($name)
	{
		$name = basename(
			$name, 
			$this->config->get('component-generator::config.postfix'
		));

		$template = $this->file->get(
			__DIR__ . 
			'/../../../views/' . 
			$this->config->get('component-generator::config.framework') . 
			'/' . 
			$name . 
			'.txt'
		);

		if($this->config->get('component-generator::config.syntax') === 'php') {
			$template = str_replace('{{ ', '<?php echo ', $template);
			return str_replace(' }}', '; ?>', $template);
		}

		return $template;
	}
}


<?php namespace Acoustep\ComponentGenerator\Generators;

use Illuminate\Filesystem\Filesystem as File;

class ComponentGenerator {
	protected $file;
	protected $config;

	public function __construct(File $file, $config)
	{
		$this->file = $file;
		$this->config = $config;
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

		return str_replace('{{name}}', $name, $template);
	}
}


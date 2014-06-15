<?php namespace Acoustep\ComponentGenerator\Generators;

use Config;
use Illuminate\Filesystem\Filesystem as File;

class ComponentGenerator {
	protected $file;

	public function __construct(File $file)
	{
		$this->file = $file;
	}
	public function make($path)
	{ 
		$name = basename($path, Config::get('component-generator::config.postfix'));
		$template = $this->getTemplate($name);

		if( ! $this->file->exists($path))
			return $this->file->put($path, $template);
		return false;
 	}

	public function getTemplate($name)
	{
		$name = basename($name, Config::get('component-generator::config.postfix'));
		$template = $this->file->get(__DIR__ . '/../../../views/' . Config::get('component-generator::config.framework') . '/' . $name . '.txt');

		return str_replace('{{name}}', $name, $template);
	}
}


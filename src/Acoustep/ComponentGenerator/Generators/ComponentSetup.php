<?php namespace Acoustep\ComponentGenerator\Generators;

use Illuminate\Filesystem\Filesystem as File;

class ComponentSetup {
	protected $file;
	protected $config;
	protected $published_config_location;

	public function __construct(File $file, $config)
	{
		$this->file = $file;
		$this->config = $config;
		$this->published_config_location = app_path().'/config/packages/acoustep/component-generator/config.php'; 
	}

	public function make($syntax, $location, $framework)
	{ 
		if($config_file = $this->getConfigFile()) {
			$published_config_contents = $this->file->get($this->published_config_location);
			$published_config_contents = $this->updateSyntax($published_config_contents, $syntax);
			$published_config_contents = $this->updateLocation($published_config_contents, $location);
			$published_config_contents = $this->updateFramework($published_config_contents, $framework);
			$this->file->put($this->published_config_location, $published_config_contents);
			return true;
		}
		return false;

 	}

	public function getConfigFile()
	{
		$config_location = $this->published_config_location;
		if( ! $this->file->exists($config_location)) {
			if( ! $this->publishConfigFile())
				return false;
		}
		return true;
	}

	public function publishConfigFile()
	{
		$directories = ['packages', 'acoustep', 'component-generator'];
		$parent = '';
		foreach($directories as $directory) {
			if( ! $this->file->isDirectory(app_path().'/config/'.$parent.$directory))
				$this->file->makeDirectory(app_path().'/config/'.$parent.$directory);
			$parent .= $directory.'/';
		}
		
		return $this->file->copy(__DIR__.'/../../../config/config.php', $this->published_config_location);
		
	}

	public function updateFramework($file, $framework)
	{
		if($framework !== 'bootstrap3') {
			$file = str_replace(
				"'framework' => 'bootstrap3'",
				"'framework' => '".$framework."'",
				$file
			);
		}
		return $file;
	}

	public function updateLocation($file, $location)
	{
		if($location !== 'app/views/components') {
			$file = str_replace(
				"'path' => 'app/views/components'",
				"'path' => '".$location."'",
				$file
			);
		}
		return $file;
	}

	public function updateSyntax($file, $syntax)
	{
		if($syntax === 'php') {
			$file = str_replace(
				"'postfix' => '.blade.php'",
				"'postfix' => '.php'",
				$file
			);
			$file = str_replace(
				"'syntax' => 'blade'",
				"'syntax' => 'php'",
				$file
			);
		}
		return $file;
	}
}




<?php namespace Acoustep\ComponentGenerator\Generators;

use Illuminate\Filesystem\Filesystem as File;

class ComponentAppender {
	protected $file;
	protected $config;

	public function __construct(File $file, $config)
	{
		$this->file = $file;
		$this->config = $config;
	}

	public function make($name, $file)
	{ 

		$template = $this->getTemplate($name);
		
		if($file = $this->getFile($file))
			return $this->file->append($file, $template);
		return false;
 	}

	public function getFile($file)
	{
		// If dot notation is used convert it to forward slash
		$file = str_replace(".", "/", $file);

		if($this->file->exists($file.".blade.php"))
			return $file.".blade.php";

		if($this->file->exists($file.".php"))
			return $file.".php";

		return false;

	}

	public function getTemplate($name)
	{
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



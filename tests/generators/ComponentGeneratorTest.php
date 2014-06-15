<?php

use Acoustep\ComponentGenerator\Generators\ComponentGenerator;
use Mockery as m;

class ComponentGeneratorTest extends PHPUnit_Framework_TestCase {
	public function tearDown()
	{
		m::close();
	}

	public function testCanGenerateComponentUsingTemplate()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem[put]');

		$file->shouldReceive('put')
			->once()
			->with('app/views/components/foo.php', file_get_contents(__DIR__.'/stubs/model.txt'));

		$generator = new ComponentGenerator($file);
		$generator->make('app/views/components/foo.blade.php');
	}

	public function testCanGenerateNavbarComponent()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem[put]');

		$file->shouldReceive('put')
			->once()
			->with('app/views/components/navbar.blade.php', file_get_contents(__DIR__.'/stubs/navbar.txt'));

		$generator = new ComponentGenerator($file);
		$generator->make('app/views/components/navbar.blade.php');

	}
}


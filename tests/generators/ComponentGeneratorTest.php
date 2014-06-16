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
			->with('app/views/components/navbar.blade.php', file_get_contents(__DIR__.'/stubs/navbar.txt'));

		$config = m::mock('ConfigMock');

		$config->shouldReceive('get')
			->twice()
			->with('component-generator::config.postfix')
			->andReturn('.blade.php');

		$config->shouldReceive('get')
			->with('component-generator::config.framework')
			->andReturn('bootstrap3');
		$generator = new ComponentGenerator($file, $config);
		$generator->make('app/views/components/navbar.blade.php');
	}

	public function testCanGenerateNavbarComponent()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem[put]');

		$file->shouldReceive('put')
			->once()
			->with('app/views/components/navbar.blade.php', file_get_contents(__DIR__.'/stubs/navbar.txt'));

		$config = m::mock('ConfigMock');

		$config->shouldReceive('get')
			->twice()
			->with('component-generator::config.postfix')
			->andReturn('.blade.php');

		$config->shouldReceive('get')
			->with('component-generator::config.framework')
			->andReturn('bootstrap3');

		$generator = new ComponentGenerator($file, $config);
		$generator->make('app/views/components/navbar.blade.php');

	}
}


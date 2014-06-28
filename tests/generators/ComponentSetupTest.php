<?php

use Acoustep\ComponentGenerator\Generators\ComponentSetup;
use Mockery as m;

class ComponentSetupTest extends PHPUnit_Framework_TestCase {
	public function tearDown()
	{
		m::close();
	}

	/**
	 * @test
	 */
	public function can_make_config_file_with_defaults()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem[put,exists,isDirectory,makeDirectory,copy]');

		$file->shouldReceive('exists')
			->with(__DIR__.'/stubs/config.php')
			->andReturn(true);

		$file->shouldReceive('put')
			->once()
			->with(
				__DIR__.'/stubs/config.php', 
				file_get_contents(__DIR__.'/stubs/config.txt'
			));

		$config = m::mock('ConfigMock');
		$generator = new ComponentSetup($file, $config, __DIR__, '/stubs');
		$result = $generator->make('blade', 'app/views/components', 'bootstrap3');

		$this->assertEquals(
			$result,
			true
		);

	}
	/**
	 * @test
	 */
	public function can_make_config_file_with_php_syntax()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem[put,exists,isDirectory,makeDirectory,copy]');

		$file->shouldReceive('exists')
			->with(__DIR__.'/stubs/config.php')
			->andReturn(true);

		$file->shouldReceive('put')
			->once()
			->with(
				__DIR__.'/stubs/config.php', 
				file_get_contents(__DIR__.'/stubs/config-php.txt'
			));

		$config = m::mock('ConfigMock');
		$generator = new ComponentSetup($file, $config, __DIR__, '/stubs');
		$result = $generator->make('php', 'app/views/components', 'bootstrap3');

		$this->assertEquals(
			$result,
			true
		);

	}

	/**
	 * @test
	 */
	public function can_change_framework()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem[put,exists,isDirectory,makeDirectory,copy]');
		$original = 'vendor/acoustep/component-generator/src/config/config.php';
		$target = 'app/config/packages/acoustep/component-generator/config.php';

		$file->shouldReceive('exists')
			->with(__DIR__.'/stubs/config.php')
			->andReturn(true);

		$file->shouldReceive('put')
			->once()
			->with(
				__DIR__.'/stubs/config.php', 
				file_get_contents(__DIR__.'/stubs/config-framework.txt'
			));

		$config = m::mock('ConfigMock');
		$generator = new ComponentSetup($file, $config, __DIR__, '/stubs');
		$result = $generator->make('blade', 'app/views/components', 'foundation5');

		$this->assertEquals(
			$result,
			true
		);

	}
}


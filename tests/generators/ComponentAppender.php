<?php

use Acoustep\ComponentGenerator\Generators\ComponentAppender;
use Mockery as m;

class ComponentAppenderTest extends PHPUnit_Framework_TestCase {
	public function tearDown()
	{
		m::close();
	}

	/**
	 * @test
	 */
	public function can_append_template_to_file()
	{
		$config = m::mock('ConfigMock');

		$config->shouldReceive('get')
			->with('component-generator::config.framework')
			->andReturn('bootstrap3');


		$config->shouldReceive('get')
			->with('component-generator::config.syntax')
			->andReturn('blade');

		$file = m::mock('Illuminate\Filesystem\Filesystem[exists,append]');

		$file->shouldReceive('exists')
			->with('app/views/components/navbar.blade.php')
			->andReturn(true);
		$file->shouldReceive('append')
			->once()
			->with(
				'app/views/components/navbar.blade.php', 
				file_get_contents(__DIR__.'/stubs/navbar.txt'
			));

		$generator = new ComponentAppender($file, $config);
		$result = $generator->make('navbar', 'app.views.components.navbar');
		$this->assertEquals(
			null,
			$result
		);

	}

	/**
	 * @test
	 */
	public function cant_append_to_new_file()
	{
		$config = m::mock('ConfigMock');

		$config->shouldReceive('get')
			->with('component-generator::config.framework')
			->andReturn('bootstrap3');


		$config->shouldReceive('get')
			->with('component-generator::config.syntax')
			->andReturn('blade');

		$file = m::mock('Illuminate\Filesystem\Filesystem[exists,append]');

		$file->shouldReceive('exists')
			->with('app/views/components/navbar.blade.php')
			->andReturn(false);

		$file->shouldReceive('exists')
			->with('app/views/components/navbar.php')
			->andReturn(false);

		$generator = new ComponentAppender($file, $config);
		$result = $generator->make('navbar', 'app.views.components.navbar');
		$this->assertEquals(
			false,
			$result
		);
	}

	/**
	 * @test
	 */
	public function _can_append_to_php_file()
	{
		$config = m::mock('ConfigMock');

		$config->shouldReceive('get')
			->with('component-generator::config.framework')
			->andReturn('bootstrap3');


		$config->shouldReceive('get')
			->with('component-generator::config.syntax')
			->andReturn('php');

		$file = m::mock('Illuminate\Filesystem\Filesystem[exists,append]');

		$file->shouldReceive('exists')
			->with('app/views/components/navbar.blade.php')
			->andReturn(false);

		$file->shouldReceive('exists')
			->with('app/views/components/navbar.php')
			->andReturn(true);

		$file->shouldReceive('append')
			->once()
			->with(
				'app/views/components/navbar.php', 
				file_get_contents(__DIR__.'/stubs/navbar-php.txt'
			));

		$generator = new ComponentAppender($file, $config);
		$result = $generator->make('navbar', 'app.views.components.navbar');
		$this->assertEquals(
			null,
			$result
		);
	}
}



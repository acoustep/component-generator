<?php

use Acoustep\ComponentGenerator\Generators\ComponentGenerator;
use Mockery as m;

class ComponentGeneratorTest extends PHPUnit_Framework_TestCase {
	public function tearDown()
	{
		m::close();
	}

	/**
	 * @test
	 */
	public function can_generate_navbar_component()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem[put]');

		$file->shouldReceive('put')
			->once()
			->with(
				'app/views/components/navbar.blade.php', 
				file_get_contents(__DIR__.'/stubs/navbar.txt'
			));

		$config = m::mock('ConfigMock');

		$config->shouldReceive('get')
			->twice()
			->with('component-generator::config.postfix')
			->andReturn('.blade.php');

		$config->shouldReceive('get')
			->with('component-generator::config.framework')
			->andReturn('bootstrap3');

		$config->shouldReceive('get')
			->with('component-generator::config.prefix')
			->andReturn('');

		$config->shouldReceive('get')
			->with('component-generator::config.syntax')
			->andReturn('blade');

		$generator = new ComponentGenerator($file, $config);
			$result = $generator->make('app/views/components/navbar.blade.php');

		$this->assertEquals(
			$result,
			null
		);

	}

	/**
	 * @test
	 */
	public function prefix_configuration_alters_file_prefix()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem[put]');

		$file->shouldReceive('put')
			->once()
			->with(
				'app/views/components/_navbar.blade.php', 
				file_get_contents(__DIR__.'/stubs/navbar.txt'
			));

		$config = m::mock('ConfigMock');

		$config->shouldReceive('get')
			->twice()
			->with('component-generator::config.postfix')
			->andReturn('.blade.php');

		$config->shouldReceive('get')
			->with('component-generator::config.framework')
			->andReturn('bootstrap3');

		$config->shouldReceive('get')
			->once()
			->with('component-generator::config.prefix')
			->andReturn('_');

		$config->shouldReceive('get')
			->with('component-generator::config.syntax')
			->andReturn('blade');

		$generator = new ComponentGenerator($file, $config);
		$generator->make('app/views/components/navbar.blade.php');
	}

	/**
	 * @test
	 */
	public function postfix_configuration_alters_file_postfix()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem[put]');

		$file->shouldReceive('put')
			->once()
			->with(
				'app/views/components/navbar.php', 
				file_get_contents(__DIR__.'/stubs/navbar.txt'
			));

		$config = m::mock('ConfigMock');

		$config->shouldReceive('get')
			->twice()
			->with('component-generator::config.postfix')
			->andReturn('.php');

		$config->shouldReceive('get')
			->with('component-generator::config.framework')
			->andReturn('bootstrap3');

		$config->shouldReceive('get')
			->once()
			->with('component-generator::config.prefix')
			->andReturn('');

		$config->shouldReceive('get')
			->with('component-generator::config.syntax')
			->andReturn('blade');

		$generator = new ComponentGenerator($file, $config);
		$generator->make('app/views/components/navbar.php');
	}

	/**
	 * @test
	 */
	public function can_generate_foundation_topbar_component()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem[put]');

		$file->shouldReceive('put')
			->once()
			->with(
				'app/views/components/topbar.blade.php', 
				file_get_contents(__DIR__.'/stubs/topbar.txt'
			));

		$config = m::mock('ConfigMock');

		$config->shouldReceive('get')
			->twice()
			->with('component-generator::config.postfix')
			->andReturn('.blade.php');

		$config->shouldReceive('get')
			->with('component-generator::config.framework')
			->andReturn('foundation5');

		$config->shouldReceive('get')
			->once()
			->with('component-generator::config.prefix')
			->andReturn('');

		$config->shouldReceive('get')
			->with('component-generator::config.syntax')
			->andReturn('blade');

		$generator = new ComponentGenerator($file, $config);
		$generator->make('app/views/components/topbar.blade.php');

	}

	/**
	 * @test
	 */
	public function can_change_generated_file_path_via_generator()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem[put]');

		$file->shouldReceive('put')
			->once()
			->with('app/views/navbar.blade.php', file_get_contents(__DIR__.'/stubs/navbar.txt'));

		$config = m::mock('ConfigMock');

		$config->shouldReceive('get')
			->twice()
			->with('component-generator::config.postfix')
			->andReturn('.blade.php');

		$config->shouldReceive('get')
			->with('component-generator::config.framework')
			->andReturn('bootstrap3');

		$config->shouldReceive('get')
			->once()
			->with('component-generator::config.prefix')
			->andReturn('');

		$config->shouldReceive('get')
			->with('component-generator::config.syntax')
			->andReturn('blade');

		$generator = new ComponentGenerator($file, $config);
		$generator->make('app/views/navbar.blade.php');

	}

	/**
	 * @test
	 */
	public function can_change_syntax_to_php()
	{
		$file = m::mock('Illuminate\Filesystem\Filesystem[put]');

		$file->shouldReceive('put')
			->once()
			->with('app/views/navbar.php', file_get_contents(__DIR__.'/stubs/navbar-php.txt'));

		$config = m::mock('ConfigMock');

		$config->shouldReceive('get')
			->twice()
			->with('component-generator::config.postfix')
			->andReturn('.php');

		$config->shouldReceive('get')
			->with('component-generator::config.framework')
			->andReturn('bootstrap3');

		$config->shouldReceive('get')
			->once()
			->with('component-generator::config.prefix')
			->andReturn('');

		$config->shouldReceive('get')
			->with('component-generator::config.syntax')
			->once()
			->andReturn('php');

		$generator = new ComponentGenerator($file, $config);
		$generator->make('app/views/navbar.php');

	}
}

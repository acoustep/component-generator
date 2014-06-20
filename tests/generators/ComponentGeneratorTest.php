<?php

use Acoustep\ComponentGenerator\Generators\ComponentGenerator;
use Mockery as m;

class ComponentGeneratorTest extends PHPUnit_Framework_TestCase {
	public function tearDown()
	{
		m::close();
	}

	public function testCanGenerateNavbarComponent()
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

	public function testPrefixConfigurationAltersFilePrefix()
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

	public function testPostfixConfigurationAltersFilePostfix()
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

	public function testCanGenerateFoundationTopbarComponent()
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

	public function testCanChangeGeneratedFilePathViaGenerator()
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

	public function testCanSyntaxToPHP()
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

	public function testCanAppendTemplateToFile()
	{
		$config = m::mock('ConfigMock');

		$config->shouldReceive('get')
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

		$generator = new ComponentGenerator($file, $config);
			$result = $generator->make('app/views/components/navbar.blade.php');
		$this->assertEquals(
			false,
			$result
		);

	}
}


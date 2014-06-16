<?php

use Acoustep\ComponentGenerator\Commands\ComponentGeneratorCommand;
use Acoustep\ComponentGenerator\Generators\ComponentGenerator;
use Symfony\Component\Console\Tester\CommandTester;
use Mockery as m;

class ComponentGeneratorCommandTest extends PHPUnit_Framework_TestCase {
	public function setUp()
	{
		parent::setUp();

		$app = m::mock('AppMock');
		$app->shouldReceive('instance')->once()->andReturn($app);

		Illuminate\Support\Facades\Facade::setFacadeApplication($app);
		Illuminate\Support\Facades\Config::swap($config = m::mock('ConfigMock'));

	}
	public function tearDown()
	{
		m::close();
	}

	public function testGeneratesComponentSuccessfully()
	{
		$gen = m::mock('Acoustep\ComponentGenerator\Generators\ComponentGenerator');

		$gen->shouldReceive('make')
			->once()
			->with('app/views/components/navbar.blade.php')
			->andReturn(true);

		$config = m::mock('ConfigMock');

		$config
			->shouldReceive('get')
			->with('component-generator::config.prefix')
			->andReturn('');

		$config
			->shouldReceive('get')
			->with('component-generator::config.postfix')
			->andReturn('.blade.php');

		$command = new ComponentGeneratorCommand($gen, $config);

		$tester = new CommandTester($command);
		$tester->execute(['name' => 'navbar']);

		$this->assertEquals(
			"Created app/views/components/navbar.blade.php\n",
			$tester->getDisplay()
		);
	}

	public function testGeneratesComponentFails()
	{
		$gen = m::mock('Acoustep\ComponentGenerator\Generators\ComponentGenerator');

		$gen->shouldReceive('make')
			->once()
			->with('app/views/components/navbar.blade.php') 
			->andReturn(false);

		$config = m::mock('ConfigMock');
		$config
			->shouldReceive('get')
			->with('component-generator::config.prefix')
			->andReturn('');

		$config
			->shouldReceive('get')
			->with('component-generator::config.postfix')
			->andReturn('.blade.php');

		$command = new ComponentGeneratorCommand($gen, $config);

		$tester = new CommandTester($command);
		$tester->execute(['name' => 'navbar']);

		$this->assertEquals(
			"Could not create app/views/components/navbar.blade.php\n",
			$tester->getDisplay()
		);

	}
}


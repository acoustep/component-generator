<?php

use Acoustep\ComponentGenerator\Commands\ComponentSetupCommand;
use Acoustep\ComponentGenerator\Generators\ComponentSetup;
use Symfony\Component\Console\Tester\CommandTester;
use Mockery as m;

class ComponentSetupCommandTest extends PHPUnit_Framework_TestCase {
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

	/**
	 * @test
	 */
	public function successfully_generates_setup()
	{
		$this->markTestIncomplete();
		$gen = m::mock('Acoustep\ComponentGenerator\Generators\ComponentSetup');
		$config = m::mock('ConfigMock');
		$gen->shouldReceive('make')
			->once()
			->with('blade', 'app/views/componenets', 'bootstrap3') 
			->andReturn(true);
		$command = new ComponentSetupCommand($gen, $config);
		$tester = new CommandTester($command);
		$tester->execute([]);

		$this->assertEquals(
			"Setup complete\n",
			$tester->getDisplay()
		);
	}
	/**
	 * @test
	 */
	public function fails_to_complete_setup()
	{
		$this->markTestIncomplete();
		$gen = m::mock('Acoustep\ComponentGenerator\Generators\ComponentSetup');

		$config = m::mock('ConfigMock');

		$gen->shouldReceive('make')
			->once()
			->with('blade', 'app/views/componenets', 'bootstrap3') 
			->andReturn(false);

		$command = new ComponentSetupCommand($gen, $config);

		$tester = new CommandTester($command);
		$tester->execute([]);

		$this->assertEquals(
			"Could not complete setup.  Check your options and file permissions.\n",
			$tester->getDisplay()
		);
	}
}




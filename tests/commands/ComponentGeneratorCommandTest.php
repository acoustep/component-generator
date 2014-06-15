<?php

use Config;
use Acoustep\ComponentGenerator\Commands\ComponentGeneratorCommand;
use Acoustep\ComponentGenerator\Generators\ComponentGenerator;
use Symfony\Component\Console\Tester\CommandTester;
use Mockery as m;

class ComponentGeneratorCommandTest extends PHPUnit_Framework_TestCase {
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

		$command = new ComponentGeneratorCommand($gen);

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

		$command = new ComponentGeneratorCommand($gen);

		$tester = new CommandTester($command);
		$tester->execute(['name' => 'foo']);

		$this->assertEquals(
			"Could not create app/views/components/navbar.blade.php\n",
			$tester->getDisplay()
		);

	}
}


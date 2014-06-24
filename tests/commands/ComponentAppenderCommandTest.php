<?php

use Acoustep\ComponentGenerator\Commands\ComponentAppenderCommand;
use Acoustep\ComponentGenerator\Generators\ComponentAppender;
use Symfony\Component\Console\Tester\CommandTester;
use Mockery as m;

class ComponentAppenderCommandTest extends PHPUnit_Framework_TestCase {
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

	public function testAppendTemplateToExistingFile()
	{
		$gen = m::mock('Acoustep\ComponentGenerator\Generators\ComponentAppender');

		$config = m::mock('ConfigMock');

		$gen->shouldReceive('make')
			->once()
			->with('layout', 'app.views.components.layout') 
			->andReturn(true);

		$command = new ComponentAppenderCommand($gen, $config);

		$tester = new CommandTester($command);
		$tester->execute(['name' => 'layout', 'file' => 'components.layout']);

		$this->assertEquals(
			"Appended layout to app/views/components/layout(.blade.php|.php).\n",
			$tester->getDisplay()
		);
	}
}



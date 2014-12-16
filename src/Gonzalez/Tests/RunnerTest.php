<?php

namespace Gonzalez\Tests;

use Gonzalez\Runner;

/**
 * Class RunnerTest
 *
 * @package Gonzalez\Tests
 *
 * @coversDefaultClass Gonzalez\Runner
 */
class RunnerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @test
	 * @testdox ::run calls callback properly without registered data provider
	 */
	public function runWithoutDataProvider() {
		$function = $this->getMock(InvokableInterface::class);
		$function->expects($this->exactly(10))
			->method('__invoke');

		$runner = new Runner($function);
		$runner->run(10, $function);
	}

	/**
	 * @test
	 * @testdox ::run calls callback properly with registered data provider
	 */
	public function runWithDataProvider() {
		$function = $this->getMock(InvokableInterface::class);
		$function->expects($this->exactly(30))
			->method('__invoke');

		$runner = new Runner($function);
		$runner->setDataProvider([[1], [2], [3]]);
		$runner->run(10, $function);
	}

	/**
	 * @test
	 * @testdox ::run never calls callback on 0 iterations
	 */
	public function runZeroIterations() {
		$function = $this->getMock(InvokableInterface::class);
		$function->expects($this->never())
			->method('__invoke');

		$runner = new Runner($function);
		$runner->run(0, $function);
	}

	/**
	 * @test
	 * @testdox ::runFor calls callback properly
	 */
	public function runIt() {
		$function = $this->getMock(InvokableInterface::class);
		$function->expects($this->atLeastOnce())
			->method('__invoke');

		$runner = new Runner($function);
		$runner->runFor(10, $function);
	}

	/**
	 * @test
	 * @testdox ::runFor never calls callback on 0 milliseconds
	 */
	public function runForZero() {
		$function = $this->getMock(InvokableInterface::class);
		$function->expects($this->never())
			->method('__invoke');

		$runner = new Runner($function);
		$runner->runFor(0, $function);
	}

	/**
	 * @test
	 * @testdox ::run returns array with count equal to iterations
	 */
	public function runReturnsArray() {
		$runner = new Runner(function () {});
		$this->assertEquals(10, count($runner->run(10)));
	}

	/**
	 * @test
	 * @testdox setter and getter for calibration time work as expected
	 */
	public function setGetCalibrationTime() {
		$runner = new Runner(function () {});
		$runner->setCalibrationTime(123);
		$this->assertEquals(123, $runner->getCalibrationTime());
	}
}

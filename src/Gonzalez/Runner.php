<?php

namespace Gonzalez;

/**
 * Class Runner
 *
 * @package Gonzalez
 */
class Runner {

	/**
	 * @var float
	 */
	private $calibration_time = 0.0;

	/**
	 * @var callable
	 */
	private $callback;

	/**
	 * @var array|\Traversable
	 */
	private $data_provider = [[null]];

	/**
	 * @param callable $callback
	 */
	public function __construct(callable $callback) {
		$this->callback = $callback;
	}

	/**
	 * @param float $milliseconds
	 *
	 * @return $this
	 */
	public function setCalibrationTime($milliseconds) {
		$this->calibration_time = $milliseconds;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getCalibrationTime() {
		return $this->calibration_time;
	}

	/**
	 * @param array|\Traversable $data_provider
	 *
	 * @return $this
	 */
	public function setDataProvider($data_provider) {
		$this->data_provider = $data_provider;

		return $this;
	}

	/**
	 * @return float Current time in milliseconds
	 */
	private function millitime() {
		return microtime(true) * 1000;
	}

	/**
	 * @param callable $callback
	 * @param array $arguments
	 *
	 * @return float
	 */
	private function timeIt() {
		$time = 0.0;
		foreach ($this->data_provider as $arguments) {
			$t0 = $this->millitime();
			call_user_func_array($this->callback, $arguments);
			$t1 = $this->millitime();
			$delta = $t1 - $t0;
			$adjusted = $delta - $this->calibration_time;

			$time += $adjusted;
		}

		return $time;
	}

	/**
	 * @param int $iterations
	 *
	 * @return float[]
	 */
	public function run($iterations) {
		$results = [];
		for ($i = 0; $i < $iterations; $i++) {
			$results[] = $this->timeIt();
		}

		return $results;
	}

	/**
	 * @param float $milliseconds
	 *
	 * @return float[]
	 */
	public function runFor($milliseconds) {
		$results = [];
		$run_time = 0.0;

		while ($run_time < $milliseconds) {
			$result = $this->timeIt();
			$results[] = $result;
			$run_time += $result;
		}

		return $results;
	}
}

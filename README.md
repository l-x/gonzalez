# Gonzalez
> ¡Ándale! ¡Ándale! ¡Arriba! ¡Arriba! ¡Epa! ¡Epa! ¡Epa! Yeehaw!

*"Gosh, yet another micro-framework for timing PHP code..*" you might say. I can deal with that. Almost.

----

## Installation

```sh
$  composer require "lx/gonzalez" "dev-master"
```

## Usage

### Setup

```php

<?php

use \Gonzalez\Runner

require_once 'vendor/autoload.php';

$function_to_benchmark = function() {
    // code to benchmark goes here...
};

$runner = new Runner($function_to_benchmark);

```

### Basics

```php
$results = $runner->run(1000);

$iterations = count($results);
$overall_time = array_sum($results);

$fastest = min($results);
$slowest = max($results);
$average = $iterations / $overall_time;

```

### Calibration

#### Why?

Let's say you want to measure how fast you can drink a pint of beer. Let's also say you have only one arm.
The steps it would take are:

1. Press `Start` in the stopwatch app in your shiny smartphone
2. Put your smartphone on the desk
3. Grab the glass
4. Drink
5. Put down the glass
6. Grab your smartphone
7. Press `Stop` in the stopwatch app in your shiny smartphone
8. Burp

What you wanted to measure was only action #4, what you actually measured was action #2 to #7. Not good.

#### How?

Gonzalez provides a simple way to calibrate your benchmarks: **Gonzalez**.

The minimum calibration you want to do is the time it takes php entering and leaving the function to benchmark. So if 
you want to benchmark an anonymous function you would take an empty anonymous function:



```php
$empty_anonymous_function = function () {};
$calibrator = new Runner($empty_anonymous_function);

$result = $calibrator->run(10000);
$calibration_time = min($result);

$runner->setCalibrationTime($calibration_time);

$result = $runner->run(1000);
// ...

```

In general your calibration function should be exactly the same as the function you want to benchmark, *excluding* the
lines of code you really want to benchmark.

----
## Bunch'o'Badges

[![Build Status](https://img.shields.io/travis/l-x/gonzalez/master.svg?style=flat-square)](https://travis-ci.org/l-x/gonzalez)
[![Test Coverage](https://img.shields.io/codeclimate/coverage/github/l-x/gonzalez.svg?style=flat-square)](https://codeclimate.com/github/l-x/gonzalez)
[![Code Climate](https://img.shields.io/codeclimate/github/l-x/gonzalez.svg?style=flat-square)](https://codeclimate.com/github/l-x/gonzalez)
[![License](https://img.shields.io/packagist/l/lx/gonzalez.svg?style=flat-square)](https://packagist.org/packages/lx/gonzalez)
[![Badges](https://img.shields.io/badge/Badges-5%2F5-orange.svg?style=flat-square)](http://shields.io)

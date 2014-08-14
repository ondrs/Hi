<?php

require __DIR__ . '/../vendor/autoload.php';

if (!class_exists('Tester\Assert')) {
	echo "Install Nette Tester using `composer update --dev`\n";
	exit(1);
}

date_default_timezone_set('Europe/Prague');

Tester\Environment::setup();

if(extension_loaded('xdebug')) {
    Tester\CodeCoverage\Collector::start(__DIR__ . '/coverage.dat');
}

// create temporary directory
define('TEMP_DIR', __DIR__ . '/tmp/' . (isset($_SERVER['argv']) ? md5(serialize($_SERVER['argv'])) : getmypid()));
Tester\Helpers::purge(TEMP_DIR);

function id($val) {
    return $val;
}

function run(Tester\TestCase $testCase) {
    $testCase->run(isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : NULL);
}

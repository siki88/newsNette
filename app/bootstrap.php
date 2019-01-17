<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

//$configurator->setDebugMode(false);
$configurator->setDebugMode(['2.245.106.148','127.0.0.1','localhost']); // enable for your remote IP 6
$configurator->enableTracy(__DIR__ . '/../log');

$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$container = $configurator->createContainer();

return $container;

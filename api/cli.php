<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$settings = require __DIR__ . '/src/settings.php';

// Add OrderEntry SOAP API
if (!file_exists(__DIR__ . '/src/orderentry/autoload.php')) {
	$generator = new \Wsdl2PhpGenerator\Generator();
	$generator->generate(
		new \Wsdl2PhpGenerator\Config(array(
			'inputFile' => $settings['settings']['wics']['wdsl_uri'],
			'outputDir' => __DIR__ . '/src/orderentry'
		))
	);
}
//require __DIR__ . '/src/orderentry/autoload.php';

$application->add(new App\Command\cmdAdnovate());
$application->add(new App\Command\cmdMessages($settings['settings']));
$application->add(new App\Command\cmdImport($settings['settings']));

$application->run();
<?php
if (PHP_SAPI == 'cli-server') {
	// To help the built-in PHP dev server, check if the request was actually for
	// something which should probably be served as a static file
	$url = parse_url($_SERVER['REQUEST_URI']);
	$file = __DIR__ . $url['path'];
	if (is_file($file)) {
		return false;
	}
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

$dotenv = new Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Add OrderEntry SOAP API
if (!file_exists(__DIR__ . '/../src/orderentry/autoload.php')) {
	$generator = new \Wsdl2PhpGenerator\Generator();
	$generator->generate(
		new \Wsdl2PhpGenerator\Config(array(
			'inputFile' => $settings['settings']['wics']['wdsl_uri'],
			'outputDir' => __DIR__ . '/../src/orderentry'
		))
	);
}
//require __DIR__ . '/../src/orderentry/autoload.php';

// Run app
$app->run();

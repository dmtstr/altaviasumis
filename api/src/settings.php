<?php
return [
	'settings' => [
		'displayErrorDetails' => true, // set to false in production
		'addContentLengthHeader' => false, // Allow the web server to send the content-length header

		// Renderer settings
		'renderer' => [
			'template_path' => __DIR__ . '/../templates/',
		],
		'schemas' => [
			'order' => __DIR__ . '/schemas/order.json',
		],
		// Monolog settings
		'logger' => [
			'name' => 'slim-app',
			'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
			'level' => \Monolog\Logger::DEBUG,
		],
		// Database connection settings
		'db' => [
			'host' => getenv('DB_HOST'),
			'dbname' => getenv('DB_DATABASE'),
			'user' => getenv('DB_USERNAME'),
			'pass' => getenv('DB_PASSWORD'),
		],
		// Database connection settings
		'wics' => [
			'wdsl_uri' => getenv('WICS_WDSL_URI')
		],
		// jwt settings
		"jwt" => [
			'secret' => 'supersecretkeyyoushouldnotcommittogithub'
		]
	],
];

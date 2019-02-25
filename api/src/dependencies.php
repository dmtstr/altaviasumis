<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
	$settings = $c->get('settings')['renderer'];
	return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
	$settings = $c->get('settings')['logger'];
	$logger = new Monolog\Logger($settings['name']);
	$logger->pushProcessor(new Monolog\Processor\UidProcessor());
	$logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
	return $logger;
};

// PDO database library
$container['db'] = function ($c) {
	$settings = $c->get('settings')['db'];
	$pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
		$settings['user'], $settings['pass']);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	return $pdo;
};

$container["JwtAuthentication"] = function ($c) {
	$settings = $c->get('settings');

	return new \Tuupola\Middleware\JwtAuthentication([
		"path" => "/api",
		"attribute" => "decoded_token_data",
		"secret" => $settings['jwt']['secret'],
		"algorithm" => ["HS256"],
		"error" => function ($response, $arguments) {
			$data["status"] = "error";
			$data["message"] = $arguments["message"];
			return $response
				->withHeader("Content-Type", "application/json")
				->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
		}
	]);
};
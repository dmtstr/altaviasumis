<?php

use Firebase\JWT\JWT;
use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function (Request $request, Response $response, array $args) {
	// Sample log message
	$this->logger->info("Slim-Skeleton '/' route");

	// Render index view
	return $this->renderer->render($response, 'index.phtml', $args);
});

$app->post('/login', function (Request $request, Response $response, array $args) {
	try {
		$message = $request->getParsedBody();
		if (!isset($message)) {
			$headers = $request->getHeaders();
			if (isset($headers['PHP_AUTH_USER'][0], $headers['PHP_AUTH_PW'][0])) {
				$message['email'] = $headers['PHP_AUTH_USER'][0];
				$message['password'] = $headers['PHP_AUTH_PW'][0];
			} else {
				throw new \Exception('Message empty or not properly formatted', 400);
			}
		}
		if (gettype($message) === 'object' && get_class($message) === 'SimpleXMLElement') {
			$message = (Array)json_decode(json_encode($message), TRUE);
		}
		if (gettype($message) === 'array') {
		} else {
			throw new \Exception('Unknown message type', 400);
		}

		$database = new \logic\database($this->db);
		$user = $database->fetch_user($message['email']);
		if (!isset($user, $user['customer_id'], $user['email'])) {
			throw new \Exception('Invalid User', 400);
		}

		if (!password_verify($message['password'], $user['password'])) {
			throw new \Exception('These credentials do not match our records', 400);
		}

		$settings = $this->get('settings'); // get settings array.

		$now = new \DateTime();
		$future = new \DateTime('now +' . 1 . ' day');
		$jti = (new \Tuupola\Base62)->encode(random_bytes(16));

		$permissions = json_decode(isset($user['permissions']) ? $user['permissions'] : null, true);

		$payload = [
			"jti" => $jti,
			"iat" => $now->getTimestamp(),
			"exp" => $future->getTimestamp(),
			"email" => $message['email'],
			"customer_id" => $user['customer_id'],
			"permissions" => $permissions
		];

		$result['token'] = JWT::encode($payload, $settings['jwt']['secret'], "HS256");
	} catch (\Exception $ex) {
		$code = $ex->getCode();
		$result['status'] = ['error' => $ex->getMessage()];
		\logic\utils::sendMail("error " . $request->getMethod() . " " . $request->getUri()->getPath(), $result);
	}
	$renderer = new RKA\ContentTypeRenderer\Renderer();
	$response = $renderer->render($request, $response, $result);

	$this->logger->debug($request->getMethod() . " " . $request->getUri()->getPath(), [$result]);

	return $response->withStatus(isset($code) ? $code : 200);
});

$app->post('/register', function (Request $request, Response $response, array $args) {
	try {
		$message = $request->getParsedBody();
		if (!isset($message)) {
			throw new \Exception('Message empty or not properly formatted', 400);
		}
		if (gettype($message) === 'object' && get_class($message) === 'SimpleXMLElement') {
			$message = (Array)json_decode(json_encode($message), TRUE);
		}
		if (gettype($message) === 'array') {
		} else {
			throw new \Exception('Unknown message type', 400);
		}

		$database = new \logic\database($this->db);
		$result['result'] = $database->modify_user($message['email'],
			[
				'email' => $message['email'],
				'password' => password_hash($message['password'], PASSWORD_BCRYPT, [
						'cost' => 12,
					]
				),
				'permissions' => '{"live":false}'
			]
		);
	} catch (\Exception $ex) {
		$code = $ex->getCode();
		$result['status'] = ['error' => $ex->getMessage()];
		\logic\utils::sendMail("error " . $request->getMethod() . " " . $request->getUri()->getPath(), $result);
	}
	$renderer = new RKA\ContentTypeRenderer\Renderer();
	$response = $renderer->render($request, $response, $result);

	$this->logger->debug($request->getMethod() . " " . $request->getUri()->getPath(), [$result]);

	return $response->withStatus(isset($code) ? $code : 200);
});

$app->group('/api', function (\Slim\App $app) {
	$app->post('/orders[/{customer_id}]', function ($request, $response, $args) {
		try {
			$database = new \logic\database($this->db);
			$token = $request->getAttribute("decoded_token_data");
			if (!isset($token, $token['email'], $token['customer_id'])) {
				throw new \Exception('Invalid Token', 400);
			}
			if ($token['customer_id'] === "-1") {
				if (!isset($args['customer_id'])) {
					throw new \Exception('Must define Customer Id', 400);
				}
				$token['customer_id'] = $args['customer_id'];
			}
			$message = (array)\logic\utils::body_to_string($request->getParsedBody());
			$message['state'] = 'UNREAD';

			$this->logger->debug($request->getMethod() . " " . $request->getUri()->getPath(), [$message]);

			if ($message['type'] === 'XML') {
				$xml = simplexml_load_string($message['content']);
				$json = json_encode($xml);
				$json = json_decode($json, TRUE);
				\logic\utils::clearEmptyArrays($json);
			}

			$settings = $this->get('settings'); // get settings array.

			// Validate
			$validator = new JsonSchema\Validator;
			$validator->validate($json, (object)['$ref' => 'file://' . $settings['schemas']['order']]);
			if (!$validator->isValid()) {
				$validationError[] = "JSON does not validate. Violations:";
				foreach ($validator->getErrors() as $error) {
					$validationError[] = $error['message'] . " in " . $error['property'];
				}
				throw new \Exception(implode("\n", $validationError), 400);
			}

			$result['status']['id'] = $database->insert_message([
				'email' => $token['email'],
				'customer_id' => $token['customer_id']
			], $message);
		} catch (\Exception $ex) {
			$code = $ex->getCode();
			$result['status'] = ['error' => $ex->getMessage()];
			\logic\utils::sendMail("error " . $request->getMethod() . " " . $request->getUri()->getPath(), $result);
		}
		$renderer = new RKA\ContentTypeRenderer\Renderer();
		$response = $renderer->render($request, $response, $result);

		$this->logger->debug($request->getMethod() . " " . $request->getUri()->getPath(), [$result]);

		return $response->withStatus(isset($code) ? $code : 200);
	});

	$app->get('/orders', function ($request, $response, $args) {
		try {
			$database = new \logic\database($this->db);
			$token = $request->getAttribute("decoded_token_data");
			if (!isset($token, $token['email'], $token['customer_id'])) {
				throw new \Exception('Invalid Token', 400);
			}
			$result = $database->get_messages($token['customer_id']);
		} catch (\Exception $ex) {
			$code = $ex->getCode();
			$result['status'] = ['error' => $ex->getMessage()];
			\logic\utils::sendMail("error " . $request->getMethod() . " " . $request->getUri()->getPath(), $result);
		}
		$renderer = new RKA\ContentTypeRenderer\Renderer();
		$response = $renderer->render($request, $response, $result);

		$this->logger->debug($request->getMethod() . " " . $request->getUri()->getPath(), [$result]);

		return $response->withStatus(isset($code) ? $code : 200);
	});

	$app->post('/stocks', function ($request, $response, $args) {
		try {
			$database = new \logic\database($this->db);
			$token = $request->getAttribute("decoded_token_data");
			if (!isset($token, $token['email'], $token['customer_id'])) {
				throw new \Exception('Invalid Token', 400);
			}
			if ($token['customer_id'] !== "-1") {
				throw new \Exception('Not Authorized', 400);
			}
			$message = (array)\logic\utils::body_to_string($request->getParsedBody());
			$result['status']['id'] = $database->insert_stock([
				'email' => $token['email'],
				'customer_id' => \logic\utils::validate($message['id'])
			], $message);
		} catch (\Exception $ex) {
			$code = $ex->getCode();
			$result['status'] = ['error' => $ex->getMessage()];
			\logic\utils::sendMail("error " . $request->getMethod() . " " . $request->getUri()->getPath(), $result);
		}
		$renderer = new RKA\ContentTypeRenderer\Renderer();
		$response = $renderer->render($request, $response, $result);

		$this->logger->debug($request->getMethod() . " " . $request->getUri()->getPath(), [$result]);

		return $response->withStatus(isset($code) ? $code : 200);
	});

	$app->get('/stocks[/{customer_id}]', function ($request, $response, $args) {
		try {
			$database = new \logic\database($this->db);
			$token = $request->getAttribute("decoded_token_data");
			if (!isset($token, $token['email'], $token['customer_id'])) {
				throw new \Exception('Invalid Token', 400);
			}
			$result = $database->fetch_stock((int)$token['customer_id']);
			$result = $result['content'];
		} catch (\Exception $ex) {
			$code = $ex->getCode();
			$result['status'] = ['error' => $ex->getMessage()];
			\logic\utils::sendMail("error " . $request->getMethod() . " " . $request->getUri()->getPath(), $result);
		}
		$renderer = new RKA\ContentTypeRenderer\Renderer();
		$response = $renderer->render($request, $response, $result);

		$this->logger->debug($request->getMethod() . " " . $request->getUri()->getPath(), [$result]);

		return $response->withStatus(isset($code) ? $code : 200);
	});

});
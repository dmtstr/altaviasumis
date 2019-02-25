<?php
/**
 * Created by PhpStorm.
 * User: superuser
 * Date: 10/20/18
 * Time: 1:33 AM
 */

namespace logic;

class utils
{
	public static function body_to_string($body): body
	{
		if (!isset($body) || empty($body)) {
			throw new \Exception('Empty or not properly formatted', 400);
		}

		$result = new body();

		if (gettype($body) === 'object' && get_class($body) === 'SimpleXMLElement') {
			$tmp = json_decode(json_encode($body), TRUE);
			if (isset($tmp['CustNum'])) {
				$result->id = $tmp['CustNum'];
			} elseif (isset($tmp['BODY']['HEAD']['ORDER_NO'])) {
				$result->id = $tmp['BODY']['HEAD']['ORDER_NO'];
			}
			$result->type = 'XML';
			$result->content = $body->asXML();
		} elseif (gettype($body) === 'array') {
			if (isset($body['CustNum'])) {
				$result->id = $body['CustNum'];
			} elseif (isset($body['BODY']['HEAD']['ORDER_NO'])) {
				$result->id = $body['BODY']['HEAD']['ORDER_NO'];
			}
			$result->type = 'JSON';
			$result->content = json_encode($body);
		} else {
			throw new \Exception('Unknown message type', 400);
		}
		return $result;
	}

	public static function validate($expression)
	{
		if (isset($expression) !== true) {
			throw new \Exception("Invalid");
		}
		return $expression;
	}

	public static function clearEmptyArrays(&$a)
	{
		if (!is_array($a)) {
			return true;
		}
		if (count($a) === 0) {
			return false;
		}
		foreach ($a as $key => &$v) {

			if (\logic\utils::clearEmptyArrays($v) === false) {
				$v = null;
			}
		}
		return true;
	}

	public static function sendMail(string $subject, $message)
	{
		ob_start();
		var_dump($message);
		$result = ob_get_clean();
		mail("adwilink@dynconnect.com, janneke.vanerp@altaviasumis.nl", "Adwilink " . $subject, $result);
	}
}
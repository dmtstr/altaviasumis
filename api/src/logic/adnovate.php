<?php
/**
 * Created by PhpStorm.
 * User: superuser
 * Date: 9/17/18
 * Time: 12:50 PM
 */

namespace logic;

class adnovate
{
	private $urlFetch = 'https://secure2.adnovate.com/engine3-prd/webservices/message/';
	private $username = 'SUMIS_VICS';
	private $password = 'psw4sumis';

	public function fetch_headers($state, $days = 30)
	{
		// create curl resource
		$ch = curl_init();

		$date = new \DateTime();
		$date->sub(new \DateInterval('P' . $days . 'D'));

		$url = $this->urlFetch .
			'getMessageList.jsp' .
			'?username=' . $this->username .
			'&password=' . $this->password .
			'&state=' . $state .
			"&startdate=" . rawurlencode($date->format('d-m-Y H:m'));

		// set url
		curl_setopt($ch, CURLOPT_URL, $url);

		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string
		$output = curl_exec($ch);

		// close curl resource to free up system resources
		curl_close($ch);

		//$xml = $this->xmlstr_to_array($output);
		$xml = simplexml_load_string($output);
		$json = json_decode(json_encode($xml), TRUE);

		if (isset($json['message'])) {
			if ($this->isAssoc($json['message'])) {
				$tmp = $json['message'];
				unset($json['message']);
				$json['message'][] = $tmp;
			}
			$json = $json['message'];
		}

		foreach ($json as &$value) {
			$value = $this->array_flatten($value);
			if (isset($value['datetime'])) {
				$value['datetime'] = date('Y-m-d H:i:s', strtotime($value['datetime']));
			}

			if (isset($value['subject'])) {
				if (strpos($value['subject'], 'Basket order requested') !== false) {
					$value['basket'] = (int)filter_var($value['subject'], FILTER_SANITIZE_NUMBER_INT);
				} else {
					$value['basket'] = 0;
				}
			}
		}
		return $json;
	}

	private function isAssoc(array $arr)
	{
		if (array() === $arr)
			return false;
		ksort($arr);
		return array_keys($arr) !== range(0, count($arr) - 1);
	}

	private function array_flatten($array)
	{
		if (!is_array($array)) {
			return false;
		}
		$result = array();
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$result = array_merge($result, $this->array_flatten($value));
			} else {
				if (isset($result[$key])) {
					throw new \Exception("array_flatten = overwrite not allowed");
				}
				$result[$key] = $value;
			}
		}
		return $result;
	}

	public function fetch_message($id)
	{
		// create curl resource
		$ch = curl_init();

		$url = $this->urlFetch .
			'getMessage.jsp' .
			'?username=' . $this->username .
			'&password=' . $this->password .
			'&messageID=' . $id;
		// set url
		curl_setopt($ch, CURLOPT_URL, $url);

		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string
		$output = curl_exec($ch);

		// close curl resource to free up system resources
		curl_close($ch);

		//$xml = simplexml_load_string($output);
		$xml = $this->xmlstr_to_array($output);
		$json = json_decode(json_encode($xml), TRUE);
		if (isset($json['BODY']['HTS-WMS']['SO_PREADVISE'])) {
			return $json['BODY']['HTS-WMS']['SO_PREADVISE'];
		}
		return array();
	}

	public function xmlstr_to_array($xmlstr)
	{
		$doc = new \DOMDocument();
		$doc->loadXML($xmlstr);
		$root = $doc->documentElement;
		$output = $this->domnode_to_array($root);
		$output['@root'] = $root->tagName;
		return $output;
	}

	private function domnode_to_array($node)
	{
		$output = array();
		switch ($node->nodeType) {
			case XML_CDATA_SECTION_NODE:
			case XML_TEXT_NODE:
				$output = trim($node->textContent);
				break;
			case XML_ELEMENT_NODE:
				for ($i = 0, $m = $node->childNodes->length; $i < $m; $i++) {
					$child = $node->childNodes->item($i);
					$v = $this->domnode_to_array($child);
					if (isset($child->tagName)) {
						$t = $child->tagName;
						if (!isset($output[$t])) {
							$output[$t] = array();
						}
						$output[$t][] = $v;
					} elseif ($v || $v === '0') {
						$output = (string)$v;
					}
				}
				if ($node->attributes->length && !is_array($output)) { //Has attributes but isn't an array
					$output = array('@content' => $output); //Change output into an array.
				}
				if (is_array($output)) {
					if ($node->attributes->length) {
						$a = array();
						foreach ($node->attributes as $attrName => $attrNode) {
							$a[$attrName] = (string)$attrNode->value;
						}
						$output['@attributes'] = $a;
					}
					foreach ($output as $t => $v) {
						if (is_array($v) && count($v) == 1 && $t != '@attributes') {
							$output[$t] = $v[0];
						}
					}
				}
				break;
		}
		return $output;
	}

	public function set_message_state($id, $state)
	{
		$url = $this->urlFetch .
			'messageReceived.jsp' .
			'?username=' . $this->username .
			'&password=' . $this->password .
			'&message=%3c%3fxml+version%3d%221.0%22+encoding%3d%22UTF-8%22%3f%3e%3cnotification%3e%3cmessageID%3e' . $id . '%3c%2fmessageID%3e%3cstate%3e' . $state . '%3c%2fstate%3e%3c%2fnotification%3e';

		// create curl resource
		$ch = curl_init();

		// set url
		curl_setopt($ch, CURLOPT_URL, $url);

		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// $output contains the output string
		$output = curl_exec($ch);

		// close curl resource to free up system resources
		curl_close($ch);

		$xml = $this->xmlstr_to_array($output);
		$json = json_decode(json_encode($xml), TRUE);
		if (isset($json['STATE']) && ($json['STATE'] === $state || $json['STATE'] === 'OK')) {
			return true;
		}
		return false;
	}

	public function process($order)
	{
		$HEAD = ($order['HEAD']);
		$BODY = ($order['BODY']);

		$Referentie = $HEAD['CUSTOMER_REF'];

		$EdiMailAdr = "geen email";
		$PhoneNum = "geen telephone";

		foreach ($HEAD['ADDRESS']['CONTACT'] as $contact) {

			if (!isset($Ref2) && isset($contact['NAME'])) {
				$Ref2 = $contact['NAME'];
			}

			if ($contact['TYPE'] === 'E' && isset($contact['VALUE'])) {
				$EdiMailAdr = $contact['VALUE'];
			}

			if ($contact['TYPE'] === 'T' && isset($contact['VALUE'])) {
				$PhoneNum = $contact['VALUE'];
			}

		}

		$ADDRESS_FIELD = explode(PHP_EOL, $HEAD['ADDRESS']['ADDRESS_FIELD']);
		$DelvName = $ADDRESS_FIELD[0];
		unset($ADDRESS_FIELD[0]);
		$ContPersName = implode(' ', $ADDRESS_FIELD);

		$STREET_HOUSE_NO = explode(' ', $HEAD['ADDRESS']['STREET_HOUSE_NO']);
		$DelvStrNum = $STREET_HOUSE_NO[count($STREET_HOUSE_NO) - 1];
		unset($STREET_HOUSE_NO[count($STREET_HOUSE_NO) - 1]);
		$DelvStreet = implode(' ', $STREET_HOUSE_NO);

		$DelvZip = strtoupper($HEAD['ADDRESS']['ZIP_CODE']);
		$DelvCity = $HEAD['ADDRESS']['CITY'];
		$DelvCntry = $HEAD['ADDRESS']['COUNTRY_CODE'];

		if ($HEAD['ORDER_MARK'] === 'SCRAP') {
			$DelvZip = '4321 AF';
			$DelvStreet = 'SCRAP ' . $DelvStreet;
		}

		$lines = array();

		if (isset($BODY['LINE']['LINE_NO'])) {
			$item = $BODY['LINE'];
			$lines[] = new \AddOrderRegel(
				$Referentie,
				$item['ARTICLE']['INT_NO'],
				"",
				$item['ARTICLE_QUANTITY']['QUANTITY']
			);
		} else {
			foreach ($BODY['LINE'] as $item) {
				$lines[] = new \AddOrderRegel(
					$Referentie,
					$item['ARTICLE']['INT_NO'],
					"",
					$item['ARTICLE_QUANTITY']['QUANTITY']
				);
			}
		}

		if (count($lines) === 0) {
			throw new \Exception("No order lines");
		}

		$service = new \OrderEntry();

		$result = $service->AddOrderHeader(new \AddOrderHeader(
				210850,
				$Referentie,
				$Ref2,
				(new \DateTime())->modify('+1 day'),
				$EdiMailAdr,
				"WEB",
				0,
				$DelvName,
				$ContPersName,
				$DelvStreet,
				$DelvStrNum,
				$DelvZip,
				$DelvCity,
				$DelvCntry,
				$PhoneNum)
		)->getAddOrderHeaderResult();
		if ($result !== 'Gedaan') {
			throw new \Exception($result);
		}

		foreach ($lines as $line) {
			$result = $service->AddOrderRegel($line)->getAddOrderRegelResult();
			if ($result !== "Gedaan") {
				$results[] = $result;
			}
		}

		if (isset($results) && is_array($results) && count($results) > 0) {
			throw new \Exception(implode("\n", $results));
		}

		$result = $service->AddOrderFinish(new \AddOrderFinish($Referentie))->getAddOrderFinishResult();
		if ($result !== "Gedaan") {
			throw new \Exception($result);
		}

		return true;
	}
}
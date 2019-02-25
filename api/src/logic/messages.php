<?php
/**
 * Created by PhpStorm.
 * User: superuser
 * Date: 9/17/18
 * Time: 12:50 PM
 */

namespace logic;

use logic\utils as utils;

class messages
{
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

	public function process($customer_id, $order)
	{
		$HEAD = utils::validate($order['HEAD']);
		$BODY = utils::validate($order['BODY']);

		$Referentie = $HEAD['ORDER_NO'] . ' / ' . $HEAD['CUSTOMER_REF'];
		$Ref2 = $HEAD['CUSTOMER_REF'];

		$EdiMailAdr = "geen email";
		$PhoneNum = "geen telephone";

		if (isset($HEAD['ADDRESS']['CONTACTS']['CONTACT'])) {
			foreach ($HEAD['ADDRESS']['CONTACTS']['CONTACT'] as $id => $contact) {
				if (!isset($contact['VALUE'])) {
					continue;
				}
				if ($contact['TYPE'] === 'E') {
					$EdiMailAdr = $contact['VALUE'];
				} elseif ($contact['TYPE'] === 'T') {
					$PhoneNum = $contact['VALUE'];
				}
				if (isset($contact['NAME']) && !isset($ContPersName)) {
					$ContPersName = $contact['NAME'];
				}
			}
		} else {
			if ($HEAD['ADDRESS']['CONTACT']['TYPE'] === 'E' && isset($HEAD['ADDRESS']['CONTACT']['VALUE'])) {
				$EdiMailAdr = $HEAD['ADDRESS']['CONTACT']['VALUE'];
			}

			if ($HEAD['ADDRESS']['CONTACT']['TYPE'] === 'T' && isset($HEAD['ADDRESS']['CONTACT']['VALUE'])) {
				$PhoneNum = $HEAD['ADDRESS']['CONTACT']['VALUE'];
			}

			if (isset($HEAD['ADDRESS']['CONTACT']['NAME'])) {
				$ContPersName = $HEAD['ADDRESS']['CONTACT']['NAME'];
			}
		}

		$DelvName = $HEAD['ADDRESS']['ADDRESS_FIELD'];
		$DelvStreet = $HEAD['ADDRESS']['STREET'];
		$DelvStrNum = $HEAD['ADDRESS']['HOUSE_NO'];
		$DelvZip = strtoupper($HEAD['ADDRESS']['ZIP_CODE']);
		$DelvCity = $HEAD['ADDRESS']['CITY'];
		$DelvCntry = $HEAD['ADDRESS']['COUNTRY_CODE'];

		$lines = array();

		if (count($BODY['LINE']) === 0) {
			throw new \Exception("Empty order");
		}

		foreach ($BODY['LINE'] as $id => $item) {
			if (is_int($id)) {
				$lines[] = new \AddOrderRegel(
					$Referentie,
					$item['ARTICLE']['INT_NO'],
					"",
					$item['ARTICLE_QUANTITY']['QUANTITY']
				);
			} elseif (is_string($id)) {
				if (!isset($BODY['LINE']['ARTICLE']['INT_NO'], $BODY['LINE']['ARTICLE_QUANTITY']['QUANTITY'])) {
					throw new \Exception("Order line missing id or quantity");
				}
				$lines[] = new \AddOrderRegel(
					$Referentie,
					$BODY['LINE']['ARTICLE']['INT_NO'],
					"",
					$BODY['LINE']['ARTICLE_QUANTITY']['QUANTITY']
				);
				break;
			} else {
				throw new \Exception("Error in order");
			}
		}

		if (count($lines) === 0) {
			throw new \Exception("No order lines");
		}

		$service = new \OrderEntry();

		$result = $service->AddOrderHeader(new \AddOrderHeader(
				$customer_id,
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

	private function isAssoc(array $arr)
	{
		if (array() === $arr)
			return false;
		ksort($arr);
		return array_keys($arr) !== range(0, count($arr) - 1);
	}
}
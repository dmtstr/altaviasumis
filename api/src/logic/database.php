<?php
/**
 * Created by PhpStorm.
 * User: superuser
 * Date: 9/17/18
 * Time: 7:05 PM
 */

namespace logic;

use PDO;

class database
{
	private $db;

	function __construct($db)
	{
		$this->db = $db;
	}

	public
	function fetch_user($email)
	{
		$sql = "SELECT * FROM users WHERE email='" . $email . "'";
		$sth = $this->getDb()->prepare($sql);
		$sth->execute();
		$result = $sth->fetch();
		return $result;
	}

	private function getDb(): PDO
	{
		if (is_object($this->db) && get_class($this->db) === 'PDO') {
			return $this->db;
		}

		$settings = $this->db;
		$pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'],
			$settings['user'], $settings['pass']);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		return $pdo;
	}

	public
	function modify_user($email, $body)
	{
		$keys = implode(",", array_keys($body));
		$values = ':' . implode(",:", array_keys($body));

		foreach ($body as $key => $value) {
			$combi[] = $key . '=values(' . $key . ')';
		}

		$sql = "INSERT INTO users (" . $keys . ") VALUES (" . $values . ") ON DUPLICATE KEY UPDATE " . implode(',', $combi);

		$sth = $this->getDb()->prepare($sql);
		foreach ($body as $key => $value) {
			$sth->bindValue(":" . $key, $value);
		}
		$sth->execute();
		$id = $this->getDb()->lastInsertId();
		return $id;
	}

	private function validate($expression)
	{
		if (isset($expression) !== true) {
			throw new \Exception("Invalid");
		}
		return $expression;
	}

	function fetch_stock(int $customer_id = -1)
	{
		$sql = "SELECT * FROM stocks";
		if ($customer_id !== -1) {
			$sql .= " WHERE customer_id=" . $customer_id;
		}
		$sth = $this->getDb()->prepare($sql);
		$sth->execute();

		$result = $sth->fetch();
		if (!isset($result, $result['content'], $result['type'])) {
			throw new \Exception('Invalid data', 400);
		}
		if ($result['type'] === 'XML') {
			$xml = simplexml_load_string($result['content']);
			$result['content'] = json_decode(json_encode($xml), TRUE);
		}
		return $result;
	}

	public
	function insert_stock($user, $message): int
	{
		$body = [
			'customer_id' => $this->validate($user['customer_id']),
			'email' => $this->validate($user['email']),
			'type' => $this->validate($message['type']),
			'content' => $this->validate($message['content']),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s"),
		];

		$sql = "SELECT id FROM stocks WHERE customer_id=" . $body['customer_id'] . " ORDER BY id DESC";
		$sth = $this->getDb()->prepare($sql);
		$sth->execute();

		if (($record = $sth->fetch()) && is_array($record) && count($record) > 0) {
			$params = array();
			foreach (array_keys($body) as $key) {
				$params[] = "$key=:$key";
			}
			$sql = "UPDATE stocks SET " . implode(",", $params) . " WHERE id=" . $record['id'];
		} else {
			$keys = implode(",", array_keys($body));
			$values = ':' . implode(",:", array_keys($body));

			$sql = "INSERT INTO stocks (" . $keys . ") VALUES (" . $values . ")";
		}
		$sth = $this->getDb()->prepare($sql);
		foreach ($body as $key => $value) {
			$sth->bindValue(":" . $key, $value);
		}
		$this->getDb()->beginTransaction();
		$sth->execute();
		$recordId = $this->getDb()->lastInsertId();
		$this->getDb()->commit();

		return $recordId;
	}

	public
	function fetch_messages(string $state = 'UNREAD', int $count = 1000)
	{
		$sql = "SELECT messages.*, users.permissions FROM messages INNER JOIN users ON users.email=messages.email WHERE messages.state='" . $state . "' ORDER BY messages.updated_at DESC LIMIT " . $count;
		$sth = $this->getDb()->prepare($sql);
		$sth->execute();
		return $sth->fetchAll();
	}

	public
	function get_messages(int $customer_id = -1)
	{
		$sql = "SELECT * FROM messages";
		if ($customer_id !== -1) {
			$sql .= " WHERE customer_id=" . $customer_id;
		}
		$sth = $this->getDb()->prepare($sql);
		$sth->execute();

		$result = array();
		foreach ($sth->fetchAll() as $key => $value) {
			if ($value['type'] === 'XML') {
				unset($value['type']);
				$xml = simplexml_load_string($value['content']);
				$json = json_encode($xml);
				$value['content'] = json_decode($json, TRUE);
				\logic\utils::clearEmptyArrays($json);
			}
			$result[] = $value;
		}
		return $result;
	}

	public
	function insert_message($user, $message)
	{

		$body = [
			'customer_id' => $this->validate($user['customer_id']),
			'email' => $this->validate($user['email']),
			'state' => $this->validate($message['state']),
			'type' => $this->validate($message['type']),
			'content' => $this->validate($message['content']),
			'created_at' => date("Y-m-d H:i:s"),
			'updated_at' => date("Y-m-d H:i:s"),
		];
		$keys = implode(",", array_keys($body));
		$values = ':' . implode(",:", array_keys($body));
		$sql = "INSERT INTO messages (" . $keys . ") VALUES (" . $values . ")";
		$sth = $this->getDb()->prepare($sql);
		foreach ($body as $key => $value) {
			$sth->bindValue(":" . $key, $value);
		}
		$sth->execute();
		return $this->getDb()->lastInsertId();
	}

	public
	function set_message_state(int $id, string $state)
	{
		$sql = "UPDATE messages SET state='" . $state . "' WHERE id=" . $id;
		$sth = $this->getDb()->prepare($sql);
		$sth->execute();
	}
}
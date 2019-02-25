<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class cmdMessages extends Command
{
	private $settings;

	public function __construct($settings, ?string $name = null)
	{
		$this->settings = $settings;
		parent::__construct($name);
	}

	protected function configure()
	{
		$this
			->setName('app:messages')
			->setDescription('Process unread messages.')
			->setHelp('This command is processing all UNREAD messages in the queue.');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$messages = new \logic\messages();
		$database = new \logic\database($this->settings['db']);
		foreach ($database->fetch_messages() as $item) {
			try {

				if (!isset($item['permissions'])) {
					continue;
				}

				$item['permissions'] = json_decode($item['permissions'], true);

				if (!isset($item['permissions']['live']) || $item['permissions']['live'] !== true) {
					continue;
				}

				if ($item['type'] === 'XML') {
					$xml = simplexml_load_string($item['content']);
					$item['content'] = json_decode(json_encode($xml), TRUE);
				}

				$result = $messages->process($item['customer_id'], $item['content']['BODY']);
				if ($result !== true) {
					throw new \Exception($result);
				}

				$database->set_message_state($item['id'], 'READ');

				\logic\utils::sendMail($item['id'], $item);

			} catch (\Exception $ex) {
				$database->set_message_state($item['id'], 'FAILED');
				\logic\utils::sendMail("error " . $item['id'], [$ex->getMessage()]);
			}
		}
	}
}
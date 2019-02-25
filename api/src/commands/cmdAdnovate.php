<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class cmdAdnovate extends Command
{
	protected function configure()
	{
		$this
			->setName('app:adnovate')
			->setDescription('Process adnovate unread messages.')
			->setHelp('This command is triggering fetching of all new messages from Adnovate.');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$adnovate = new \logic\adnovate();
		foreach ($adnovate->fetch_headers('ALL', 5) as &$item) {
			try {
				if (strpos($item['subject'], "Material requested") !== FALSE
					|| strpos($item['subject'], "Distribution list requested") !== FALSE) {
					if ($item['state'] !== 'READ') {
						$adnovate->set_message_state($item['id'], 'READ');
					}
					continue;
				}

				if ($item['state'] === 'READ') {
					continue;
				}

				$content = $adnovate->fetch_message($item['id']);

				$item['result'] = $adnovate->process($content);
				if ($item['result'] !== true) {
					throw new \Exception($item['result']);
				}
				$adnovate->set_message_state($item['id'], 'READ');

				\logic\utils::sendMail($item['id'], $item);

			} catch (\Exception $ex) {
				$adnovate->set_message_state($item['id'], 'FAILED');
				\logic\utils::sendMail("error " . $item['id'], [$ex->getMessage()]);
			}
		}
	}
}
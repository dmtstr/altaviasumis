<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class cmdImport extends Command
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
			->setName('app:import')
			->setDescription('Import messages.')
			->setHelp('');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		/*
		$database = new \logic\database($this->settings['db']);
		foreach (glob("/home/superuser/etos/*.xml") as $file) {
			$message = [
				'state' => 'UNREAD',
				'type' => 'XML',
				'content' => file_get_contents($file)
			];
			$result['status']['id'] = $database->insert_message([
				'email' => 'system',
				'customer_id' => '0'
			], $message);
		}
		*/
	}
}
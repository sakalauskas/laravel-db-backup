<?php namespace Coreproc\LaravelDbBackup\Databases;

use Coreproc\LaravelDbBackup\Console;
use Config;

class MongodbDatabase implements DatabaseInterface
{

	protected $console;
	protected $database;
	protected $user;
	protected $password;
	protected $host;
	protected $port;

	public function __construct(Console $console, $database, $host, $port, $user, $password)
	{
		$this->console = $console;
		$this->database = $database;
		$this->user = $user;
		$this->password = $password;
		$this->host = $host;
		$this->port = $port;
	}

	public function dump($destinationFile)
	{
		$command = sprintf('mongodump --host %s:%s --username=%s --password=%s --db=%s --out %s',
			escapeshellarg($this->host),
			escapeshellarg($this->port),
			escapeshellarg($this->user),
			escapeshellarg($this->password),
			escapeshellarg($this->database),
			escapeshellarg($destinationFile)
		);

		return $this->console->run($command);
	}

	public function restore($sourceFile)
	{
		$command = sprintf('mongorestore --host %s:%s --username=%s --password=%s --db=%s  %s',
			escapeshellarg($this->host),
			escapeshellarg($this->port),
			escapeshellarg($this->user),
			escapeshellarg($this->password),
			escapeshellarg($this->database),
			escapeshellarg($sourceFile)
		);

		return $this->console->run($command);
	}

	public function getFileExtension()
	{
		return 'mongo';
	}

}

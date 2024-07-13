<?php

namespace App\Database;

use Dotenv\Dotenv;

class Connection
{
	private static $instance = null;

	public static function getInstance()
	{
		if (self::$instance === null) {
			$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
			$dotenv->load();

			$host = $_ENV['DB_HOST'];
			$port = $_ENV['DB_PORT'];
			$database = $_ENV['DB_DATABASE'];
			$username = $_ENV['DB_USERNAME'];
			$password = $_ENV['DB_PASSWORD'];

			$socket = isset($_ENV['DB_SOCKET']) ? $_ENV['DB_SOCKET'] : null;

			try {
				if ($socket) {
					self::$instance = new \mysqli(null, $username, $password, $database, null, $socket);
				} else {
					self::$instance = new \mysqli($host, $username, $password, $database, $port);
				}

				if (self::$instance->connect_error) {
					throw new \mysqli_sql_exception('Connection failed: ' . self::$instance->connect_error);
				}
			} catch (\mysqli_sql_exception $e) {
				die('Connection failed: ' . $e->getMessage());
			}
		}

		return self::$instance;
	}
}
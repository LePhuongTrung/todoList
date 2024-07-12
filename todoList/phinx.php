<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Debug: Print environment variables to check if they are loaded
var_dump($_ENV);

return [
	'paths' => [
		'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
		'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
	],
	'environments' => [
		'default_migration_table' => 'phinxlog',
		'default_environment' => 'development',
		'production' => [
			'adapter' => 'mysql',
			'host' => $_ENV['DB_HOST'],
			'name' => $_ENV['DB_DATABASE'],
			'user' => $_ENV['DB_USERNAME'],
			'pass' => $_ENV['DB_PASSWORD'],
			'port' => $_ENV['DB_PORT'],
			'charset' => 'utf8',
		],
		'development' => [
			'adapter' => 'mysql',
			'host' => $_ENV['DB_HOST'],
			'name' => $_ENV['DB_DATABASE'],
			'user' => $_ENV['DB_USERNAME'],
			'pass' => $_ENV['DB_PASSWORD'],
			'port' => $_ENV['DB_PORT'],
			'charset' => 'utf8',
		],
		'testing' => [
			'adapter' => 'mysql',
			'host' => $_ENV['DB_HOST'],
			'name' => $_ENV['DB_DATABASE_TEST'],
			'user' => $_ENV['DB_USERNAME'],
			'pass' => $_ENV['DB_PASSWORD'],
			'port' => $_ENV['DB_PORT'],
			'charset' => 'utf8',
		]
	],
	'version_order' => 'creation'
];

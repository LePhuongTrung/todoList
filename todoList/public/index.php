<?php

require __DIR__ . '/../vendor/autoload.php';
session_start();

$uri = $_SERVER['REQUEST_URI'];

$router = require __DIR__ . '/../app/routes.php';

if (isset($_SESSION['message'])) {
	$message = $_SESSION['message'];
	unset($_SESSION['message']);
} else {
	$message = null;
}

$router->dispatch($uri);

if ($message) {
	echo '<script>';
	if ($message['status'] === 'success') {
		echo 'alert("' . $message['text'] . '");';
	} else {
		echo 'alert("' . $message['text'] . '");';
	}
	echo '</script>';
}

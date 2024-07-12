<?php

require '../vendor/autoload.php';

use App\Controller\HomeController;

// Basic routing (for demonstration purposes)
$controller = new HomeController();
$controller->index();

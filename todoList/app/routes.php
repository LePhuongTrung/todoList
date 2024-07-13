<?php

use App\Router;
use App\Controllers\CalendarController;
use App\Controllers\WorkController;

$router = new Router();

$router->addRoute('GET', '/', CalendarController::class, 'showCalendar');

$router->addRoute('POST', '/works', WorkController::class, 'store');
$router->addRoute('GET', '/works/:id', WorkController::class, 'show');
return $router;

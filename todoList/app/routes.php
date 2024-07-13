<?php

use App\Router;
use App\Controllers\CalendarController;
use App\Controllers\WorkController;

$router = new Router();

$router->addRoute('GET', '/', CalendarController::class, 'showCalendar');

$router->addRoute('POST', '/works', WorkController::class, 'store');
$router->addRoute('GET', '/works/:id', WorkController::class, 'show');
$router->addRoute('PATCH', '/works/:id', WorkController::class, 'update');
$router->addRoute('DELETE', '/works/:id', WorkController::class, 'delete');
return $router;

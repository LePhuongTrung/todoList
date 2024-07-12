<?php

use App\Router;
use App\Controllers\CalendarController;
use App\Controllers\WorkController;

$router = new Router();

$router->addRoute('GET', '/', CalendarController::class, 'showCalendar');

$router->addRoute('POST', '/save-work', WorkController::class, 'saveWork');

return $router;

<?php

require '../vendor/autoload.php';

use App\Controllers\CalendarController;

$controller = new CalendarController();
$controller->showCalendar();

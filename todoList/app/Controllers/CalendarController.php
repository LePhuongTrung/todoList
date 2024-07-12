<?php

namespace App\Controllers;

class CalendarController
{
	public function showCalendar()
	{
		$events = $this->getEvents();
		include __DIR__ . '/../views/calendar.php';
	}

	private function getEvents()
	{
		return [
			[
				'title' => 'Event 1',
				'start' => date('Y-m-d')
			],
			[
				'title' => 'Event 2',
				'start' => date('Y-m-d', strtotime('+7 days'))
			]
		];
	}
}
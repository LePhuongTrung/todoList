<?php

namespace App\Controllers;

use App\Controller;
use App\Models\WorkModel;

class CalendarController extends Controller
{
	private $workModel;

	public function __construct()
	{
		$this->workModel = new WorkModel();
	}

	public function showCalendar()
	{
		$start = $_GET['start'] ?? date('Y-m-01');
		$end = $_GET['end'] ?? date('Y-m-t');

		$rawWorks = $this->workModel->listWork($start, $end);
		$works = [];

		foreach ($rawWorks as $row) {
			$works[] = [
				'title' => $row['name'],
				'start' => $row['start_date'],
				'end' => $row['end_date']
			];
		}
		$this->render('calendar/index', ['works' => $works]);
	}
}
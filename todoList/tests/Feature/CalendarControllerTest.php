<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\CalendarController;
use App\Database\Connection;

class CalendarControllerTest extends TestCase
{
	private $db;
	private $calendarController;

	protected function setUp(): void
	{
		$this->db = Connection::getInstance();

		$this->db->query('DELETE FROM works');

		$this->db->query("INSERT INTO works (name, start_date, end_date) VALUES ('Test Work 1', '2023-07-01', '2023-07-02')");
		$this->db->query("INSERT INTO works (name, start_date, end_date) VALUES ('Test Work 2', '2023-07-10', '2023-07-11')");

		$this->calendarController = new CalendarController();
	}

	protected function tearDown(): void
	{
		$this->db->query('DELETE FROM works');
	}

	public function testShowCalendarWithAllRecords()
	{
		$_GET['start'] = '2023-07-01';
		$_GET['end'] = '2023-07-31';

		ob_start();
		$this->calendarController->showCalendar();
		$output = ob_get_clean();

		$this->assertStringContainsString('Test Work 1', $output);
		$this->assertStringContainsString('2023-07-01', $output);
		$this->assertStringContainsString('2023-07-02', $output);

		$this->assertStringContainsString('Test Work 2', $output);
		$this->assertStringContainsString('2023-07-10', $output);
		$this->assertStringContainsString('2023-07-11', $output);
	}

	public function testShowCalendarWithOnlyFirstRecord()
	{
		$_GET['start'] = '2023-07-01';
		$_GET['end'] = '2023-07-02';

		ob_start();
		$this->calendarController->showCalendar();
		$output = ob_get_clean();

		$this->assertStringContainsString('Test Work 1', $output);
		$this->assertStringContainsString('2023-07-01', $output);
		$this->assertStringContainsString('2023-07-02', $output);

		$this->assertStringNotContainsString('Test Work 2', $output);
		$this->assertStringNotContainsString('2023-07-10', $output);
		$this->assertStringNotContainsString('2023-07-11', $output);
	}

	public function testShowCalendarWithOnlySecondRecord()
	{
		$_GET['start'] = '2023-07-10';
		$_GET['end'] = '2023-07-11';

		ob_start();
		$this->calendarController->showCalendar();
		$output = ob_get_clean();

		$this->assertStringNotContainsString('Test Work 1', $output);
		$this->assertStringNotContainsString('2023-07-01', $output);
		$this->assertStringNotContainsString('2023-07-02', $output);

		$this->assertStringContainsString('Test Work 2', $output);
		$this->assertStringContainsString('2023-07-10', $output);
		$this->assertStringContainsString('2023-07-11', $output);
	}

	public function testShowCalendarWithPartialSecondRecord()
	{
		$_GET['start'] = '2023-07-11';
		$_GET['end'] = '2023-07-12';

		ob_start();
		$this->calendarController->showCalendar();
		$output = ob_get_clean();

		$this->assertStringNotContainsString('Test Work 1', $output);
		$this->assertStringNotContainsString('2023-07-01', $output);
		$this->assertStringNotContainsString('2023-07-02', $output);

		$this->assertStringContainsString('Test Work 2', $output);
		$this->assertStringContainsString('2023-07-10', $output);
		$this->assertStringContainsString('2023-07-11', $output);
	}
}
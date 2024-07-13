<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\WorkController;
use App\Database\Connection;
use App\Models\WorkModel;

class WorkControllerTest extends TestCase
{
	private $db;
	private $workController;
	private $workModel;
	private $workId;

	protected function setUp(): void
	{
		echo "Running testIndexWithAllRecords\n";
		$this->db = Connection::getInstance();
		$this->db->query('DELETE FROM works');

		$this->db->query("INSERT INTO works (name, start_date, end_date) VALUES ('Test Work 1', '2023-07-01', '2023-07-02')");
		$this->workId = $this->db->insert_id;
		$this->db->query("INSERT INTO works (name, start_date, end_date) VALUES ('Test Work 2', '2023-07-10', '2023-07-11')");

		$this->workController = new WorkController();
		$this->workModel = new WorkModel();

		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		$_SESSION = [];
	}

	protected function tearDown(): void
	{
		$this->db->query('DELETE FROM works');
	}

	public function testIndexWithAllRecords()
	{
		$_GET['start'] = '2023-07-01';
		$_GET['end'] = '2023-07-31';

		ob_start();
		$this->workController->index();
		$output = ob_get_clean();

		$this->assertStringContainsString('Test Work 1', $output);
		$this->assertStringContainsString('2023-07-01', $output);
		$this->assertStringContainsString('2023-07-02', $output);

		$this->assertStringContainsString('Test Work 2', $output);
		$this->assertStringContainsString('2023-07-10', $output);
		$this->assertStringContainsString('2023-07-11', $output);
	}

	public function testIndexWithOnlyFirstRecord()
	{
		$_GET['start'] = '2023-07-01';
		$_GET['end'] = '2023-07-02';

		ob_start();
		$this->workController->index();
		$output = ob_get_clean();

		$this->assertStringContainsString('Test Work 1', $output);
		$this->assertStringContainsString('2023-07-01', $output);
		$this->assertStringContainsString('2023-07-02', $output);

		$this->assertStringNotContainsString('Test Work 2', $output);
		$this->assertStringNotContainsString('2023-07-10', $output);
		$this->assertStringNotContainsString('2023-07-11', $output);
	}

	public function testIndexWithOnlySecondRecord()
	{
		$_GET['start'] = '2023-07-10';
		$_GET['end'] = '2023-07-11';

		ob_start();
		$this->workController->index();
		$output = ob_get_clean();

		$this->assertStringNotContainsString('Test Work 1', $output);
		$this->assertStringNotContainsString('2023-07-01', $output);
		$this->assertStringNotContainsString('2023-07-02', $output);

		$this->assertStringContainsString('Test Work 2', $output);
		$this->assertStringContainsString('2023-07-10', $output);
		$this->assertStringContainsString('2023-07-11', $output);
	}

	public function testIndexWithPartialSecondRecord()
	{
		$_GET['start'] = '2023-07-11';
		$_GET['end'] = '2023-07-12';

		ob_start();
		$this->workController->index();
		$output = ob_get_clean();

		$this->assertStringNotContainsString('Test Work 1', $output);
		$this->assertStringNotContainsString('2023-07-01', $output);
		$this->assertStringNotContainsString('2023-07-02', $output);

		$this->assertStringContainsString('Test Work 2', $output);
		$this->assertStringContainsString('2023-07-10', $output);
		$this->assertStringContainsString('2023-07-11', $output);
	}



	public function testStore()
	{
		$statusOptions = $this->workModel->getStatusOptions();
		$validStatus = $statusOptions[0];

		$_SERVER['REQUEST_METHOD'] = 'POST';
		$_POST['work_name'] = 'New Work';
		$_POST['work_start_date'] = '2023-08-01';
		$_POST['work_end_date'] = '2023-08-02';
		$_POST['work_status'] = $validStatus;

		ob_start();
		$this->workController->store();
		ob_end_clean();

		$works = $this->db->query("SELECT * FROM works WHERE name = 'New Work'")->fetch_all();
		$this->assertCount(1, $works);
		$this->assertEquals('New Work', $works[0]['name']);
		$this->assertEquals('2023-08-01', $works[0]['start_date']);
		$this->assertEquals('2023-08-02', $works[0]['end_date']);
		$this->assertEquals($validStatus, $works[0]['status']);
	}

	public function testShow()
	{
		ob_start();
		$this->workController->show($this->workId);
		$output = ob_get_clean();

		$this->assertStringContainsString('Test Work 1', $output);
		$this->assertStringContainsString('2023-07-01', $output);
		$this->assertStringContainsString('2023-07-02', $output);
	}

	public function testShowWorkNotFound()
	{
		ob_start();
		$this->workController->show(999);
		ob_end_clean();

		$this->assertEquals('error', $_SESSION['message']['status']);
		$this->assertEquals('Work not found', $_SESSION['message']['text']);
	}

	public function testUpdate()
	{
		$id = $this->workId;
		$data = [
			'work_name' => 'Updated Work',
			'work_start_date' => '2023-09-01',
			'work_end_date' => '2023-09-02',
			'work_status' => 'Completed'
		];

		$_SERVER['REQUEST_METHOD'] = 'PUT';
		file_put_contents('php://input', json_encode($data));

		ob_start();
		$this->workController->update($id);
		$output = ob_get_clean();

		$this->assertStringContainsString('success', $output);

		$work = $this->db->query("SELECT * FROM works WHERE id = $id")->fetch_row();
		$this->assertEquals('Updated Work', $work['name']);
		$this->assertEquals('2023-09-01', $work['start_date']);
		$this->assertEquals('2023-09-02', $work['end_date']);
		$this->assertEquals('Completed', $work['status']);
	}

	public function testUpdateFailure()
	{
		$data = [
			'work_name' => 'Invalid Update',
			'work_start_date' => '2023-09-01',
			'work_end_date' => '2023-09-02',
			'work_status' => 'Completed'
		];

		$_SERVER['REQUEST_METHOD'] = 'PUT';
		file_put_contents('php://input', json_encode($data));

		ob_start();
		$this->workController->update(999);
		$output = ob_get_clean();

		$this->assertStringContainsString('error', $output);
		$this->assertStringContainsString('Failed to update work', $output);
	}

	public function testDelete()
	{
		$id = $this->workId;

		ob_start();
		$this->workController->delete($id);
		$output = ob_get_clean();

		$this->assertStringContainsString('success', $output);

		$work = $this->db->query("SELECT * FROM works WHERE id = $id")->fetch_row();
		$this->assertFalse($work);
	}

	public function testDeleteFailure()
	{
		ob_start();
		$this->workController->delete(999);
		$output = ob_get_clean();

		$this->assertStringContainsString('error', $output);
		$this->assertStringContainsString('Failed to delete work', $output);
	}
}

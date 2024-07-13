<?php

namespace App\Controllers;

use App\Models\WorkModel;

class WorkController
{
	private $workModel;

	public function __construct()
	{
		$this->workModel = new WorkModel();
	}

	public function getStatusOptions()
	{
		return $this->workModel->getStatusOptions();
	}

	public function store()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$name = $_POST['work_name'];
			$startDate = $_POST['work_start_date'];
			$endDate = $_POST['work_end_date'];
			$status = $_POST['work_status'];

			$result = $this->workModel->saveWork($name, $startDate, $endDate, $status);

			if ($result) {
				$_SESSION['message'] = ['status' => 'success', 'text' => 'Work saved successfully'];
			} else {
				$_SESSION['message'] = ['status' => 'error', 'text' => 'Failed to save work'];
			}

			header("Location: /");
			exit();
		}
	}

	public function show($id)
	{
		$work = $this->workModel->getWorkById($id);
		if ($work) {
			header('Content-Type: application/json');
			echo json_encode($work);
			exit();
		}

		$_SESSION['message'] = ['status' => 'error', 'text' => 'Work not found'];
		header("Location: /");
		exit();
	}

	public function update($id)
	{
		$data = json_decode(file_get_contents('php://input'), true);

		$updateSuccess = $this->workModel->updateWorkById($id, $data);

		if ($updateSuccess) {
			header('Content-Type: application/json');
			echo json_encode(['status' => 'success', 'message' => 'Work updated successfully']);
			exit();
		}

		header('Content-Type: application/json', true, 500);
		echo json_encode(['status' => 'error', 'message' => 'Failed to update work']);
		exit();
	}

	public function delete($id)
	{
		$deleteSuccess = $this->workModel->deleteWorkById($id);

		if ($deleteSuccess) {
			header('Content-Type: application/json');
			echo json_encode(['status' => 'success', 'message' => 'Work deleted successfully']);
			exit();
		}

		header('Content-Type: application/json', true, 500);
		echo json_encode(['status' => 'error', 'message' => 'Failed to delete work']);
		exit();
	}
}
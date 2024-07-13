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

	public function saveWork()
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
}

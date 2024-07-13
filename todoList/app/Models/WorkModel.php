<?php

namespace App\Models;

use App\Database\Connection;

class WorkModel
{
	private $db;

	public function __construct()
	{
		$this->db = Connection::getInstance();
	}

	public function getStatusOptions()
	{
		$query = "SHOW COLUMNS FROM works LIKE 'status'";
		$result = $this->db->query($query);
		$row = $result->fetch_assoc();

		$enumValues = str_replace("'", "", substr($row['Type'], 5, (strlen($row['Type']) - 6)));
		$enumValuesArray = explode(',', $enumValues);

		return $enumValuesArray;
	}

	public function saveWork($name, $startDate, $endDate, $status)
	{
		$stmt = $this->db->prepare("INSERT INTO works (name, start_date, end_date, status, created) VALUES (?, ?, ?, ?, NOW())");
		$stmt->bind_param('ssss', $name, $startDate, $endDate, $status);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function listWork($start, $end)
	{
		$stmt = $this->db->prepare("SELECT * FROM works WHERE (start_date <= ? AND end_date >= ?) OR (start_date >= ? AND start_date <= ?) OR (end_date >= ? AND end_date <= ?)");
		$stmt->bind_param('ssssss', $end, $start, $start, $end, $start, $end);
		$stmt->execute();

		$result = $stmt->get_result();
		$works = [];

		while ($row = $result->fetch_assoc()) {
			$works[] = $row;
		}

		return $works;
	}

	public function getWorkById($id)
	{
		$stmt = $this->db->prepare("SELECT id, name, start_date, end_date, status FROM works WHERE id = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();

		$result = $stmt->get_result();
		return $result->fetch_assoc();
	}

	public function updateWorkById($id, $data)
	{
		$stmt = $this->db->prepare("UPDATE works SET name = ?, start_date = ?, end_date = ?, status = ?, updated = NOW() WHERE id = ?");
		$stmt->bind_param('ssssi', $data['work_name'], $data['work_start_date'], $data['work_end_date'], $data['work_status'], $id);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteWorkById($id)
	{
		$stmt = $this->db->prepare("DELETE FROM works WHERE id = ?");
		$stmt->bind_param('i', $id);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}
}

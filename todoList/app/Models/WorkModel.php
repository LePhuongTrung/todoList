<?php

namespace App\Models;

use App\Database\Connection;

class WorkModel
{
	public function getStatusOptions()
	{
		$mysqli = Connection::getInstance();

		$query = "SHOW COLUMNS FROM works LIKE 'status'";
		$result = $mysqli->query($query);
		$row = $result->fetch_assoc();

		$enumValues = str_replace("'", "", substr($row['Type'], 5, (strlen($row['Type']) - 6)));
		$enumValuesArray = explode(',', $enumValues);

		return $enumValuesArray;
	}

	public function saveWork($name, $startDate, $endDate, $status)
	{
		$mysqli = Connection::getInstance();

		$stmt = $mysqli->prepare("INSERT INTO works (name, start_date, end_date, status, created) VALUES (?, ?, ?, ?, NOW())");
		$stmt->bind_param('ssss', $name, $startDate, $endDate, $status);

		if ($stmt->execute()) {
			return true;
		} else {
			return false;
		}
	}

	public function listWork($start, $end)
	{
		$mysqli = Connection::getInstance();

		$stmt = $mysqli->prepare("SELECT * FROM works WHERE (start_date <= ? AND end_date >= ?) OR (start_date >= ? AND start_date <= ?) OR (end_date >= ? AND end_date <= ?)");
		$stmt->bind_param('ssssss', $end, $start, $start, $end, $start, $end);
		$stmt->execute();

		$result = $stmt->get_result();
		$works = [];

		while ($row = $result->fetch_assoc()) {
			$works[] = $row;
		}

		return $works;
	}
}

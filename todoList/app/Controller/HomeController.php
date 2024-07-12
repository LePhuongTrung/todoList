<?php

namespace App\Controller;

use App\Model\HomeModel;

class HomeController
{
	public function index()
	{
		$model = new HomeModel();
		$data = $model->getData();

		// Load the view
		require_once __DIR__ . '/../View/home.php';
	}
}

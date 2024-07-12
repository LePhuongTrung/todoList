<?php

namespace App\Model;

class HomeModel
{
	public function getData()
	{
		return [
			'title' => 'Welcome to My MVC App',
			'content' => 'This is a simple PHP MVC application.'
		];
	}
}
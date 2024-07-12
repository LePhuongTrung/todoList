<?php

namespace App;

class Router
{
	protected $routes = [];

	public function addRoute($method, $route, $controller, $action)
	{
		$this->routes[strtoupper($method)][$route] = ['controller' => $controller, 'action' => $action];
	}

	public function dispatch($uri)
	{
		$method = $_SERVER['REQUEST_METHOD'];

		if (isset($this->routes[$method][$uri])) {
			$controllerName = $this->routes[$method][$uri]['controller'];
			$action = $this->routes[$method][$uri]['action'];

			if (class_exists($controllerName)) {
				$controller = new $controllerName();
				if (method_exists($controller, $action)) {
					$controller->$action();
				} else {
					throw new \Exception("Action $action not found in controller $controllerName");
				}
			} else {
				throw new \Exception("Controller $controllerName not found");
			}
		} else {
			throw new \Exception("No route found for URI: $uri and method: $method");
		}
	}
}

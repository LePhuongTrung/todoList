<?php

namespace App;

class Router
{
	protected $routes = [];

	public function addRoute($method, $route, $controller, $action)
	{
		$this->routes[strtoupper($method)][] = ['route' => $route, 'controller' => $controller, 'action' => $action];
	}

	public function dispatch($uri)
	{
		$method = $_SERVER['REQUEST_METHOD'];

		if (isset($this->routes[$method])) {
			foreach ($this->routes[$method] as $route) {
				$pattern = preg_replace('#:([\w]+)#', '([\w-]+)', $route['route']);
				$pattern = "#^{$pattern}$#";

				if (preg_match($pattern, $uri, $matches)) {
					array_shift($matches);

					$controllerName = $route['controller'];
					$action = $route['action'];

					if (class_exists($controllerName)) {
						$controller = new $controllerName();
						if (method_exists($controller, $action)) {
							return call_user_func_array([$controller, $action], $matches);
						} else {
							throw new \Exception("Action $action not found in controller $controllerName");
						}
					} else {
						throw new \Exception("Controller $controllerName not found");
					}
				}
			}
		}

		throw new \Exception("No route found for URI: $uri and method: $method");
	}
}
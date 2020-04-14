<?php

namespace FastRouteTest;

use FastRoute\RouteCollector;

class DummyRouteCollector extends RouteCollector{

	public array $routes = [];

	/** @noinspection PhpMissingParentConstructorInspection */
	public function __construct(){
	}

	public function addRoute(array $httpMethods, string $route, $handler):RouteCollector{
		$this->routes[] = [$httpMethods, $route, $handler];

		return $this;
	}
}

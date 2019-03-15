<?php
namespace FastRouteTest;

use FastRoute\RouteCollector;

class DummyRouteCollector extends RouteCollector
{
    public $routes = [];

    public function __construct()
    {
    }

    public function addRoute(array $httpMethods, string $route, $handler):RouteCollector
    {
        $this->routes[] = [$httpMethods, $route, $handler];
        return $this;
    }
}

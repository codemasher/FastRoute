<?php

namespace FastRoute;

use FastRoute\DataGenerator\DataGeneratorInterface;
use FastRoute\RouteParser\RouteParserInterface;

class RouteCollector
{
    /** @var \FastRoute\RouteParser\RouteParserInterface */
    protected RouteParserInterface $routeParser;

    /** @var \FastRoute\DataGenerator\DataGeneratorInterface */
    protected DataGeneratorInterface $dataGenerator;

    /**
     * Constructs a route collector.
     *
     * @param \FastRoute\RouteParser\RouteParserInterface     $routeParser
     * @param \FastRoute\DataGenerator\DataGeneratorInterface $dataGenerator
     */
    public function __construct(RouteParserInterface $routeParser, DataGeneratorInterface $dataGenerator)
    {
        $this->routeParser = $routeParser;
        $this->dataGenerator = $dataGenerator;
    }

    /**
     * Adds a route to the collection.
     *
     * The syntax used in the $route string depends on the used route parser.
     *
     * @param string[] $httpMethods
     * @param string   $route
     * @param mixed    $handler
     *
     * @return \FastRoute\RouteCollector
     */
    public function addRoute(array $httpMethods, string $route, $handler):RouteCollector
    {
        $routeDatas = $this->routeParser->parse($route);
        foreach ($httpMethods as $method) {
            foreach ($routeDatas as $routeData) {
                $this->dataGenerator->addRoute($method, $routeData, $handler);
            }
        }

        return $this;
    }

    /**
     * @param string $route
     * @param mixed  $handler
     *
     * @return \FastRoute\RouteCollector
     */
    public function any(string $route, $handler):RouteCollector
    {
        $this->addRoute(['*'], $route, $handler);

        return $this;
    }

    /**
     * Adds a GET route to the collection
     *
     * This is simply an alias of $this->addRoute('GET', $route, $handler)
     *
     * @param string $route
     * @param mixed  $handler
     *
     * @return \FastRoute\RouteCollector
     */
    public function get(string $route, $handler):RouteCollector
    {
        $this->addRoute(['GET'], $route, $handler);

        return $this;
    }

    /**
     * Adds a POST route to the collection
     *
     * This is simply an alias of $this->addRoute('POST', $route, $handler)
     *
     * @param string $route
     * @param mixed  $handler
     *
     * @return \FastRoute\RouteCollector
     */
    public function post(string $route, $handler):RouteCollector
    {
        $this->addRoute(['POST'], $route, $handler);

        return $this;
    }

    /**
     * Adds a PUT route to the collection
     *
     * This is simply an alias of $this->addRoute('PUT', $route, $handler)
     *
     * @param string $route
     * @param mixed  $handler
     *
     * @return \FastRoute\RouteCollector
     */
    public function put(string $route, $handler):RouteCollector
    {
        $this->addRoute(['PUT'], $route, $handler);

        return $this;
    }

    /**
     * Adds a DELETE route to the collection
     *
     * This is simply an alias of $this->addRoute('DELETE', $route, $handler)
     *
     * @param string $route
     * @param mixed  $handler
     *
     * @return \FastRoute\RouteCollector
     */
    public function delete(string $route, $handler):RouteCollector
    {
        $this->addRoute(['DELETE'], $route, $handler);

        return $this;
    }

    /**
     * Adds a PATCH route to the collection
     *
     * This is simply an alias of $this->addRoute('PATCH', $route, $handler)
     *
     * @param string $route
     * @param mixed  $handler
     *
     * @return \FastRoute\RouteCollector
     */
    public function patch(string $route, $handler):RouteCollector
    {
        $this->addRoute(['PATCH'], $route, $handler);

        return $this;
    }

    /**
     * Adds a HEAD route to the collection
     *
     * This is simply an alias of $this->addRoute('HEAD', $route, $handler)
     *
     * @param string $route
     * @param mixed  $handler
     *
     * @return \FastRoute\RouteCollector
     */
    public function head(string $route, $handler):RouteCollector
    {
        $this->addRoute(['HEAD'], $route, $handler);

        return $this;
    }

    /**
     * Adds an OPTIONS route to the collection
     *
     * This is simply an alias of $this->addRoute('OPTIONS', $route, $handler)
     *
     * @param string $route
     * @param mixed  $handler
     *
     * @return \FastRoute\RouteCollector
     */
    public function options(string $route, $handler):RouteCollector
    {
        $this->addRoute(['OPTIONS'], $route, $handler);

        return $this;
    }

    /**
     * Returns the collected route data, as provided by the data generator.
     *
     * @return array
     */
    public function getData():array
    {
        return $this->dataGenerator->getData();
    }
}

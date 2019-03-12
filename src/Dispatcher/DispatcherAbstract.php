<?php

namespace FastRoute\Dispatcher;

abstract class DispatcherAbstract implements DispatcherInterface
{
    /** @var mixed[][] */
    protected $staticRouteMap = [];

    /** @var mixed[] */
    protected $variableRouteData = [];

    public function __construct(array $data)
    {
        [$this->staticRouteMap, $this->variableRouteData] = $data;
    }

    abstract protected function dispatchVariableRoute(array $routeData, string $uri):DispatchedRoute;

    public function dispatch(string $httpMethod, string $uri):DispatchedRoute
    {
        if (isset($this->staticRouteMap[$httpMethod][$uri])) {
            return new DispatchedRoute(self::FOUND, $this->staticRouteMap[$httpMethod][$uri]);
        }

        if (isset($this->variableRouteData[$httpMethod])) {
            $result = $this->dispatchVariableRoute($this->variableRouteData[$httpMethod], $uri);
            if ($result->status === self::FOUND) {
                return $result;
            }
        }

        // For HEAD requests, attempt fallback to GET
        if ($httpMethod === 'HEAD') {
            if (isset($this->staticRouteMap['GET'][$uri])) {
                 return new DispatchedRoute(self::FOUND, $this->staticRouteMap['GET'][$uri]);
            }
            if (isset($this->variableRouteData['GET'])) {
                $result = $this->dispatchVariableRoute($this->variableRouteData['GET'], $uri);
                if ($result->status === self::FOUND) {
                    return $result;
                }
            }
        }

        // If nothing else matches, try fallback routes
        if (isset($this->staticRouteMap['*'][$uri])) {
            return new DispatchedRoute(self::FOUND, $this->staticRouteMap['*'][$uri]);
        }
        if (isset($this->variableRouteData['*'])) {
            $result = $this->dispatchVariableRoute($this->variableRouteData['*'], $uri);
            if ($result->status === self::FOUND) {
                return $result;
            }
        }

        // Find allowed methods for this URI by matching against all other HTTP methods as well
        $allowedMethods = [];

        foreach ($this->staticRouteMap as $method => $uriMap) {
            if ($method !== $httpMethod && isset($uriMap[$uri])) {
                $allowedMethods[] = $method;
            }
        }

        foreach ($this->variableRouteData as $method => $routeData) {
            if ($method === $httpMethod) {
                continue;
            }

            $result = $this->dispatchVariableRoute($routeData, $uri);
            if ($result->status === self::FOUND) {
                $allowedMethods[] = $method;
            }
        }

        // If there are no allowed methods the route simply does not exist
        if ($allowedMethods) {
            return new DispatchedRoute(self::METHOD_NOT_ALLOWED, null, null, $allowedMethods);
        }

        return new DispatchedRoute(self::NOT_FOUND);
    }
}

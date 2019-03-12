<?php

namespace FastRoute\Dispatcher;

class DispatcherMarkBased extends DispatcherAbstract
{
    protected function dispatchVariableRoute(array $routeData, string $uri):DispatchedRoute
    {
        foreach ($routeData as $data) {
            $preg_match = preg_match($data['regex'], $uri, $matches);
            \FastRoute\catch_preg_error(__METHOD__, $data['regex'], $uri);

            if (!$preg_match) {
                continue;
            }

            [$handler, $varNames] = $data['routeMap'][$matches['MARK']];

            $vars = [];
            $i = 0;
            foreach ($varNames as $varName) {
                $vars[$varName] = $matches[++$i];
            }
            return new DispatchedRoute(self::FOUND, $handler, $vars);
        }

        return new DispatchedRoute(self::NOT_FOUND);
    }
}

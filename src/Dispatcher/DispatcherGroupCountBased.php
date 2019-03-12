<?php

namespace FastRoute\Dispatcher;

class DispatcherGroupCountBased extends DispatcherAbstract
{
    protected function dispatchVariableRoute(array $routeData, string $uri):array
    {
        foreach ($routeData as $data) {
            $preg_match = preg_match($data['regex'], $uri, $matches);
            \FastRoute\catch_preg_error(__METHOD__, $data['regex'], $uri);

            if (!$preg_match) {
                continue;
            }

            [$handler, $varNames] = $data['routeMap'][count($matches)];

            $vars = [];
            $i = 0;
            foreach ($varNames as $varName) {
                $vars[$varName] = $matches[++$i];
            }
            return [self::FOUND, $handler, $vars];
        }

        return [self::NOT_FOUND];
    }
}

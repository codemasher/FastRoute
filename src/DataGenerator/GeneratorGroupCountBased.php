<?php

namespace FastRoute\DataGenerator;

class GeneratorGroupCountBased extends DataGeneratorAbstract
{
    protected function processChunk(array $regexToRoutesMap):array
    {
        $routeMap = [];
        $regexes = [];
        $numGroups = 0;
        foreach ($regexToRoutesMap as $regex => $route) {
            $numVariables = \count($route->variables);
            $numGroups = \max($numGroups, $numVariables);

            $regexes[] = $regex . \str_repeat('()', $numGroups - $numVariables);
            $routeMap[$numGroups + 1] = [$route->handler, $route->variables];

            ++$numGroups;
        }

        $regex = '~^(?|' . \implode('|', $regexes) . ')$~';
        return ['regex' => $regex, 'routeMap' => $routeMap];
    }
}

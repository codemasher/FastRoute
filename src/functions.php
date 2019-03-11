<?php

namespace FastRoute;

use FastRoute\DataGenerator\GeneratorGroupCountBased;
use FastRoute\Dispatcher\{DispatcherInterface, DispatcherGroupCountBased};
use FastRoute\RouteParser\Std;

if (!function_exists('FastRoute\simpleDispatcher')) {
    /**
     * @param callable $routeDefinitionCallback
     * @param array $options
     *
     * @return \FastRoute\Dispatcher\DispatcherInterface
     */
    function simpleDispatcher(callable $routeDefinitionCallback, array $options = []):DispatcherInterface
    {
        $options += [
            'routeParser' => Std::class,
            'dataGenerator' => GeneratorGroupCountBased::class,
            'dispatcher' => DispatcherGroupCountBased::class,
            'routeCollector' => RouteCollector::class,
        ];

        /** @var RouteCollector $routeCollector */
        $routeCollector = new $options['routeCollector'](
            new $options['routeParser'], new $options['dataGenerator']
        );
        $routeDefinitionCallback($routeCollector);

        return new $options['dispatcher']($routeCollector->getData());
    }

    /**
     * @param callable $routeDefinitionCallback
     * @param array $options
     *
     * @return \FastRoute\Dispatcher\DispatcherInterface
     */
    function cachedDispatcher(callable $routeDefinitionCallback, array $options = []):DispatcherInterface
    {
        $options += [
            'routeParser' => Std::class,
            'dataGenerator' => GeneratorGroupCountBased::class,
            'dispatcher' => DispatcherGroupCountBased::class,
            'routeCollector' => RouteCollector::class,
            'cacheDisabled' => false,
        ];

        if (!isset($options['cacheFile'])) {
            throw new \LogicException('Must specify "cacheFile" option');
        }

        if (!$options['cacheDisabled'] && file_exists($options['cacheFile'])) {
            $dispatchData = require $options['cacheFile'];
            if (!is_array($dispatchData)) {
                throw new \RuntimeException('Invalid cache file "' . $options['cacheFile'] . '"');
            }
            return new $options['dispatcher']($dispatchData);
        }

        $routeCollector = new $options['routeCollector'](
            new $options['routeParser'], new $options['dataGenerator']
        );
        $routeDefinitionCallback($routeCollector);

        /** @var RouteCollector $routeCollector */
        $dispatchData = $routeCollector->getData();
        if (!$options['cacheDisabled']) {
            file_put_contents(
                $options['cacheFile'],
                '<?php return ' . var_export($dispatchData, true) . ';'
            );
        }

        return new $options['dispatcher']($dispatchData);
    }
}

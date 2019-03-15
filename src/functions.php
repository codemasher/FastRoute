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
            if (!\is_array($dispatchData)) {
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
            \file_put_contents(
                $options['cacheFile'],
                '<?php return ' . \var_export($dispatchData, true) . ';'
            );
        }

        return new $options['dispatcher']($dispatchData);
    }

    function catch_preg_error(string $fn, string $pattern, string $data):void{
        $preg_error = \preg_last_error();

        if($preg_error !== \PREG_NO_ERROR){
            $errors = [
                \PREG_INTERNAL_ERROR        => 'PREG_INTERNAL_ERROR',
                \PREG_BACKTRACK_LIMIT_ERROR => 'PREG_BACKTRACK_LIMIT_ERROR',
                \PREG_RECURSION_LIMIT_ERROR => 'PREG_RECURSION_LIMIT_ERROR',
                \PREG_BAD_UTF8_ERROR        => 'PREG_BAD_UTF8_ERROR',
                \PREG_BAD_UTF8_OFFSET_ERROR => 'PREG_BAD_UTF8_OFFSET_ERROR',
                \PREG_JIT_STACKLIMIT_ERROR  => 'PREG_JIT_STACKLIMIT_ERROR',
            ];

            throw new \RuntimeException(
                $fn.': '.($errors[$preg_error] ?? 'unknown preg_error').PHP_EOL
                .'pattern: '.$pattern.PHP_EOL
                .'data: '.$data
            );
        }
    }
}

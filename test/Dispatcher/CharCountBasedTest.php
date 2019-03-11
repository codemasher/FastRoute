<?php

namespace FastRouteTest\Dispatcher;

use FastRoute\DataGenerator\GeneratorCharCountBased;
use FastRoute\Dispatcher\DispatcherCharCountBased;

class CharCountBasedTest extends DispatcherTest
{
    protected function getDispatcherClass()
    {
        return DispatcherCharCountBased::class;
    }

    protected function getDataGeneratorClass()
    {
        return GeneratorCharCountBased::class;
    }
}

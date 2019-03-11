<?php

namespace FastRouteTest\Dispatcher;

use FastRoute\DataGenerator\GeneratorGroupCountBased;
use FastRoute\Dispatcher\DispatcherGroupCountBased;

class GroupCountBasedTest extends DispatcherTest
{
    protected function getDispatcherClass()
    {
        return DispatcherGroupCountBased::class;
    }

    protected function getDataGeneratorClass()
    {
        return GeneratorGroupCountBased::class;
    }
}

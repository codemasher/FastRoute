<?php

namespace FastRouteTest\Dispatcher;

use FastRoute\DataGenerator\GeneratorGroupPosBased;
use FastRoute\Dispatcher\DispatcherGroupPosBased;

class GroupPosBasedTest extends DispatcherTest
{
    protected function getDispatcherClass()
    {
        return DispatcherGroupPosBased::class;
    }

    protected function getDataGeneratorClass()
    {
        return GeneratorGroupPosBased::class;
    }
}

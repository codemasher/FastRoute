<?php

namespace FastRouteTest\Dispatcher;

class GroupCountBasedTest extends DispatcherTest
{
    protected function getDispatcherClass()
    {
        return 'FastRoute\\Dispatcher\\GroupCountBased';
    }

    protected function getDataGeneratorClass()
    {
        return 'FastRoute\\DataGenerator\\GroupCountBased';
    }
}

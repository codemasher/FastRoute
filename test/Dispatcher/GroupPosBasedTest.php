<?php

namespace FastRouteTest\Dispatcher;

use FastRoute\DataGenerator\GeneratorGroupPosBased;
use FastRoute\Dispatcher\DispatcherGroupPosBased;

class GroupPosBasedTest extends DispatcherTest{

	protected function getDispatcherClass():string{
		return DispatcherGroupPosBased::class;
	}

	protected function getDataGeneratorClass():string{
		return GeneratorGroupPosBased::class;
	}

}

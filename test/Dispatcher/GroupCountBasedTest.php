<?php

namespace FastRouteTest\Dispatcher;

use FastRoute\DataGenerator\GeneratorGroupCountBased;
use FastRoute\Dispatcher\DispatcherGroupCountBased;

class GroupCountBasedTest extends DispatcherTest{

	protected function getDispatcherClass():string{
		return DispatcherGroupCountBased::class;
	}

	protected function getDataGeneratorClass():string{
		return GeneratorGroupCountBased::class;
	}

}

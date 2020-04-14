<?php

namespace FastRouteTest\Dispatcher;

use FastRoute\DataGenerator\GeneratorCharCountBased;
use FastRoute\Dispatcher\DispatcherCharCountBased;

class CharCountBasedTest extends DispatcherTest{

	protected function getDispatcherClass():string{
		return DispatcherCharCountBased::class;
	}

	protected function getDataGeneratorClass():string{
		return GeneratorCharCountBased::class;
	}

}

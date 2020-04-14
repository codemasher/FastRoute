<?php

namespace FastRouteTest\Dispatcher;

use FastRoute\DataGenerator\GeneratorMarkBased;
use FastRoute\Dispatcher\DispatcherMarkBased;

class MarkBasedTest extends DispatcherTest{

	public function setUp():void{
		\preg_match('/(*MARK:A)a/', 'a', $matches);

		if(!isset($matches['MARK'])){
			$this->markTestSkipped('PHP 5.6 required for MARK support');
		}
	}

	protected function getDispatcherClass():string{
		return DispatcherMarkBased::class;
	}

	protected function getDataGeneratorClass():string{
		return GeneratorMarkBased::class;
	}

}

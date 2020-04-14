<?php

namespace FastRouteTest;

use FastRoute\RouteCollector;
use PHPUnit\Framework\TestCase;

use function FastRoute\simpleDispatcher;

class PregErrorTest extends TestCase{

	protected function setUp():void{
		// http://php.net/manual/pcre.configuration.php
		\ini_set('pcre.backtrack_limit', '1000000');
		\ini_set('pcre.recursion_limit', '100000');

		// disable the troublemaker
#		\ini_set('pcre.jit', '0');
	}

	// https://github.com/nikic/FastRoute/issues/167
	public function testPregBacktrackLimitError():void{
		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage(
			'FastRoute\\Dispatcher\\DispatcherGroupCountBased::dispatchVariableRoute: PREG_BACKTRACK_LIMIT_ERROR'.\PHP_EOL.
			'pattern: ~^(?|/((?:a?a?)*)/complicated|/(a+)())$~'.\PHP_EOL.
			'data: /aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa' // @infinite_scream
		);

		(simpleDispatcher(
			function(RouteCollector $r){
				$r->addRoute(['GET'], '/{p:(?:a?a?)*}/complicated', 'complicated_pattern');
				$r->addRoute(['GET'], '/{p:a+}', 'a');
			}
		))->dispatch('GET', '/'.\str_repeat('a', 42));

	}

}

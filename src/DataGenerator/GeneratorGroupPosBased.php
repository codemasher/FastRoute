<?php

namespace FastRoute\DataGenerator;

class GeneratorGroupPosBased extends DataGeneratorAbstract{

	protected function processChunk(array $regexToRoutesMap):array{
		$routeMap = [];
		$regexes  = [];
		$offset   = 1;

		foreach($regexToRoutesMap as $regex => $route){
			$regexes[]         = $regex;
			$routeMap[$offset] = [$route->handler, $route->variables];

			$offset += \count($route->variables);
		}

		return [
			'regex'    => '~^(?:'.\implode('|', $regexes).')$~',
			'routeMap' => $routeMap
		];
	}

}

<?php

namespace FastRoute\DataGenerator;

class GeneratorMarkBased extends DataGeneratorAbstract{

	protected int $approxChunkSize = 30;

	protected function processChunk(array $regexToRoutesMap):array{
		$routeMap = [];
		$regexes  = [];
		$markName = 'a';

		foreach($regexToRoutesMap as $regex => $route){
			$regexes[]           = $regex.'(*MARK:'.$markName.')';
			$routeMap[$markName] = [$route->handler, $route->variables];

			++$markName;
		}

		return [
			'regex'    => '~^(?|'.\implode('|', $regexes).')$~',
			'routeMap' => $routeMap
		];
	}

}
